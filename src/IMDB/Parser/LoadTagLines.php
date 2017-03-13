<?php

namespace MovieParser\IMDB\Parser;


class LoadTagLines
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessTagLines
	 */
	private $processTagLines;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessTagLines $processTagLines
	)
	{
		$this->processTagLines = $processTagLines;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_TAG_LINE)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processTagLines->process($content->getBody()->getContents());
				$movie->setTagLines($data['tagLines']);
			}
		}

		return $movie;
	}
}