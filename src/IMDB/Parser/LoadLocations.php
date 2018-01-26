<?php

namespace MovieParser\IMDB\Parser;


class LoadLocations
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessLocations
	 */
	private $processLocations;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessLocations $processLocations
	)
	{
		$this->processLocations = $processLocations;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_LOCATIONS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processLocations->process($content->getBody()->getContents());
				$movie->setLocations($data['locations']);
			}
		}

		return $movie;
	}
}