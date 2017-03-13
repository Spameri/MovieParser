<?php

namespace MovieParser\IMDB\Parser;


class LoadTrivia
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessTrivia
	 */
	private $processTrivia;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessTrivia $processTrivia
	)
	{
		$this->processTrivia = $processTrivia;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_TRIVIA)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processTrivia->process($content->getBody()->getContents());
				$triviaData = [];
				foreach ($data['trivia'] as $value) {
					$trivia = new \MovieParser\IMDB\DTO\Trivia();
					$trivia->setId($value['id']);
					$trivia->setText(implode(' ', $value['text']));
					$trivia->setVideo($movie->getId());
					preg_match('/\d+/', $value['relevancy'], $relevancy);
					$trivia->setRelevancy(reset($relevancy));
					$triviaData[] = $trivia;
				}
				$movie->setTrivia($triviaData);
			}
		}

		return $movie;
	}
}