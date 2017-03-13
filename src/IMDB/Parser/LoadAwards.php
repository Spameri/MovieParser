<?php

namespace MovieParser\IMDB\Parser;


class LoadAwards
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessAwards
	 */
	private $processAwards;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessAwards $processAwards
	)
	{
		$this->processAwards = $processAwards;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_AWARDS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processAwards->process($content->getBody()->getContents());

				$movie->setAwards($data['awards']);
			}
		}

		return $movie;
	}
}