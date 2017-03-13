<?php

namespace MovieParser\IMDB\Parser;

class LoadAlternativeVersions
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessAlternativeVersions
	 */
	private $processAlternativeVersions;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessAlternativeVersions $processAlternativeVersions
	)
	{
		$this->processAlternativeVersions = $processAlternativeVersions;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_ALTERNATE)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processAlternativeVersions->process($content->getBody()->getContents());

				$movie->setAlternativeVersions($data['alternate']);
			}
		}

		return $movie;
	}
}