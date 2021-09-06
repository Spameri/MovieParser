<?php

namespace MovieParser\IMDB\Parser;


class LoadMedia
{

	/**
	 * @var \GuzzleHttp\Client
	 */
	public $client;

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessMedia
	 */
	private $processMedia;

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessImage
	 */
	private $processImage;


	public function __construct(
		\MovieParser\IMDB\UrlBuilder $urlBuilder
		, \MovieParser\IMDB\Matcher\ProcessMedia $processMedia
		, \MovieParser\IMDB\Matcher\ProcessImage $processImage
	)
	{
		$this->processMedia = $processMedia;
		$this->processImage = $processImage;
		$this->client = new \GuzzleHttp\Client();
	}


	public function loadMedia(
		string $link,
		\MovieParser\IMDB\DTO\Movie $movie
	) : \MovieParser\IMDB\DTO\Movie
	{
		if (\strpos($link, \MovieParser\IMDB\UrlBuilder::URL_MEDIA_INDEX)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processMedia->process($content->getBody()->getContents());
				\Tracy\Debugger::barDump($data);
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				foreach ($data['mediaTypes'] as $mediaType) {
					$mediaTypeUrl = \MovieParser\IMDB\UrlBuilder::URL_IMDB_NO_BACKLASH . $mediaType;
					$mediaContent = $this->client->get($mediaTypeUrl);
					$mediaData = $this->processMedia->process($mediaContent->getBody()->getContents());
					$imageType = $this->getImageType($mediaTypeUrl);

//					$mediaData['pages'][-1] = '1';
					$mediaData['pages'] = [-1 => '1'];
					ksort($mediaData['pages']);
					foreach ($mediaData['pages'] as $page) {
						$this->loadPage($movie, $mediaType, $page, $imageType);
					}
				}
			}
		}

		return $movie;
	}


	public function loadPage(
		\MovieParser\IMDB\DTO\Movie $movie,
		string $mediaTypeUrl,
		int $page,
		int $imageType
	): void
	{
		$mediaPageContent = $this->client->get(\MovieParser\IMDB\UrlBuilder::URL_IMDB_NO_BACKLASH . $mediaTypeUrl . '&page=' . $page);
		$mediaPageData = $this->processMedia->process($mediaPageContent->getBody()->getContents());
		foreach ($mediaPageData['media'] as $image) {
			try {
				$imageId = $this->getImageId($image['link']);
				$imageData = $this->loadImageData(\MovieParser\IMDB\UrlBuilder::URL_IMDB_NO_BACKLASH . $image['link']);
				$movie->addImage($this->createImage($imageId, $imageData, $imageType));

			} catch (\Throwable $exception) {}
		}
	}


	public function createImage(
		int $imageId,
		\stdClass $imageObject,
		int $imageType
	) : \MovieParser\IMDB\DTO\Image
	{
		$imageEntity = new \MovieParser\IMDB\DTO\Image();
		$imageEntity->setId($imageId);
		$imageEntity->setVideo($imageObject->titles[0]->id ?? '');
		$imageEntity->setAuthor($imageObject->createdBy ?? '');
		$imageEntity->setCopyright($imageObject->copyright ?? '');
		$imageEntity->setSrc($imageObject->url ?? '');
		$imageEntity->setTitle($imageObject->caption->plainText ?? '');
		$imageEntity->setType($imageType);


		$characters = [];
		$people = [];
		foreach ($imageObject->names as $name) {
			if ($name->__typename === 'Name') {
				$people[] = $name;
			} else {
				\Tracy\Debugger::barDump($name);
			}
		}

		$imageEntity->setCharacters($characters);
		$imageEntity->setPeople($people);

		return $imageEntity;
	}


	public function getImageType(string $string) : int
	{
		$type = 0;

		if (strpos($string, 'event')) {
			$type = 1;
		} elseif (strpos($string, 'still_frame')) {
			$type = 2;
		} elseif (strpos($string, 'publicity')) {
			$type = 3;
		} elseif (strpos($string, 'production_art')) {
			$type = 4;
		}

		return $type;
	}


	public function getImageId(string $string) : int
	{
		preg_match('/\d+/', $string, $output);

		if ( ! isset($output[0])) {
			throw new \MovieParser\IMDB\Exception\IncompleteId();
		}

		return (int) $output[0];
	}


	public function getImageImdbId(string $string) : string
	{
		preg_match('/rm\d+/', $string, $output);

		if ( ! isset($output[0])) {
			throw new \MovieParser\IMDB\Exception\IncompleteId();
		}

		return $output[0];
	}


	/**
	 * @throws \MovieParser\IMDB\Exception\BadResponseException
	 * @throws \Nette\Utils\JsonException
	 */
	public function loadImageData(string $link) : \stdClass
	{
		$content = $this->client->get($link);
		if ($content->getStatusCode() !== \MovieParser\IMDB\Parser::STATUS_OK) {
			throw new \MovieParser\IMDB\Exception\BadResponseException('Image for link ' . $link . ' was not downloaded.');
		}

		$imageData = $this->processImage->process($content->getBody()->getContents());

		$jsonDecode = \Nette\Utils\Json::decode($imageData['imageData']);
		$first = \reset($jsonDecode->props->urqlState);

		if (isset($first->data->name->images->edges[0]->node)) {
			return $first->data->name->images->edges[0]->node;
		}

		if (isset($first->data->title->images->edges[0]->node)) {
			return $first->data->title->images->edges[0]->node;
		}

		throw new \MovieParser\IMDB\Exception\BadResponseException('Malformed image data.');
	}
}
