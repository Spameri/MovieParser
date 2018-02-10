<?php

namespace MovieParser\IMDB\Parser;

class LoadVideoGallery
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessVideoGallery
	 */
	private $processVideoGallery;

	/**
	 * @var \MovieParser\IMDB\UrlBuilder
	 */
	private $urlBuilder;

	/**
	 * @var \MovieParser\IMDB\Parser\LoadVideo
	 */
	private $loadVideo;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessVideoGallery $processVideoGallery
		, \MovieParser\IMDB\UrlBuilder $urlBuilder
		, LoadVideo $loadVideo
	)
	{
		$this->processVideoGallery = $processVideoGallery;
		$this->urlBuilder = $urlBuilder;
		$this->client = new \GuzzleHttp\Client();
		$this->loadVideo = $loadVideo;
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_VIDEO_GALLERY)) {
			$baseUrl = $this->urlBuilder->buildUrl($link);
			$content = $this->client->get($link);
			$data = $this->processVideoGallery->process($content->getBody()->getContents());

			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				if (\count($data['pages'])) {
					foreach ($data['pages'] as $page) {
						if ($page === 'Next »') {
							continue;
						}
						$mediaPageContent = $this->client->get($baseUrl . \MovieParser\IMDB\UrlBuilder::URL_VIDEO_GALLERY . '?page=' . $page);
						$mediaPageData = $this->processVideoGallery->process($mediaPageContent->getBody()->getContents());
						foreach ($mediaPageData['videos'] as $item) {
							$data['videos'][] = $item;
						}
					}
				}
				$videos = [];

				foreach ($data['videos'] as $videoLink) {
					$videos[] = $this->loadVideo->load('http://www.imdb.com/video/imdb/' . $videoLink);
				}

				$movie->setVideos($videos);
			}
		}

		return $movie;
	}
}
