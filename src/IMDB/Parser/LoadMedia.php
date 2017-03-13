<?php

namespace MovieParser\IMDB\Parser;


class LoadMedia
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessMedia
	 */
	private $processMedia;

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessImage
	 */
	private $processImage;

	/**
	 * @var \MovieParser\IMDB\UrlBuilder
	 */
	private $urlBuilder;


	public function __construct(
		\MovieParser\IMDB\UrlBuilder $urlBuilder
		, \MovieParser\IMDB\Matcher\ProcessMedia $processMedia
		, \MovieParser\IMDB\Matcher\ProcessImage $processImage
	)
	{
		$this->urlBuilder = $urlBuilder;
		$this->processMedia = $processMedia;
		$this->processImage = $processImage;
		$this->client = new \GuzzleHttp\Client();
	}


	public function loadMedia(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_MEDIA_INDEX)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processMedia->process($content->getBody()->getContents());
				$baseUrl = $this->urlBuilder->buildUrl($link);
				$imageData = $this->loadImageData($baseUrl . \MovieParser\IMDB\UrlBuilder::URL_MEDIA_VIEWER);
				$imageEntities = [];

				foreach ($data['mediaTypes'] as $mediaType) {
					$mediaTypeUrl = rtrim(\MovieParser\IMDB\UrlBuilder::URL_IMDB, '/') . $mediaType;
					$mediaContent = $this->client->get($mediaTypeUrl);
					$mediaData = $this->processMedia->process($mediaContent->getBody()->getContents());
					$imageType = $this->getImageType($mediaTypeUrl);

					foreach ($mediaData['media'] as $image) {
						try {
							$imageEntities[] = $this->createImage($image, $imageData, $imageType);
						} catch (\Throwable $exception) {

						}
					}

					if (count($mediaData['pages'])) {
						foreach ($mediaData['pages'] as $page) {
							$mediaPageContent = $this->client->get($mediaTypeUrl . '&page=' . $page);
							$mediaPageData = $this->processMedia->process($mediaPageContent->getBody()->getContents());
							foreach ($mediaPageData['media'] as $image) {
								try {
									$imageEntities[] = $this->createImage($image, $imageData, $imageType);
								} catch (\Throwable $exception) {

								}
							}
						}
					}
				}

				$movie->setImages($imageEntities);
			}
		}

		return $movie;
	}


	public function createImage($image, $imageData, $imageType)
	{
		$imageEntity = new \MovieParser\IMDB\DTO\Image();
		$imageEntity->setId($this->getImageId($image['link']));
		$imageObject = $imageData[$imageEntity->getId()];
		$imageEntity->setVideo($imageObject->relatedTitles[0]->constId ?? '');
		$imageEntity->setAuthor($imageObject->createdBy ?? '');
		$imageEntity->setCopyright($imageObject->copyright ?? '');
		$imageEntity->setSrc($imageObject->src ?? '');
		$imageEntity->setTitle($imageObject->altText ?? '');
		$imageEntity->setCharacters($imageObject->relatedCharacters ?? '');
		$imageEntity->setPeople($imageObject->relatedNames ?? '');
		$imageEntity->setType($imageType);

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


	public function getImageId(string $string) : string
	{
		preg_match('/rm\d+/', $string, $output);

		if ( ! isset($output[0])) {
			throw new \MovieParser\IMDB\Exception\IncompleteId;
		}

		return $output[0];
	}


	public function loadImageData(string $link) : array
	{
		$data = [];
		$content = $this->client->get($link);
		if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
			$imageData = $this->processImage->process($content->getBody()->getContents());

			$jsonDecode = json_decode($imageData['imageData']);
			/**
			 * @var $allImages array
			 */
			$allImages = $jsonDecode->mediaViewerModel->allImages;
			foreach ($allImages as $item) {
				$data[$item->id] = $item;
			}
		}

		return $data;
	}
}