<?php

namespace MovieParser\IMDB\Parser;


class LoadQuotes
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessQuotes
	 */
	private $processQuotes;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessQuotes $processQuotes
	)
	{
		$this->processQuotes = $processQuotes;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_QUOTES)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processQuotes->process($content->getBody()->getContents());
				$quotesData = [];
				foreach ($data['quotes'] as $value) {
					$quote = new \MovieParser\IMDB\DTO\Quote();
					$quote->setId($value['id']);
					$quote->setText(implode(' ', $value['text']));
					$quote->setVideo($movie->getId());
					preg_match('/\d+/', $value['relevancy'], $relevancy);
					$quote->setRelevancy(reset($relevancy));
					$quotesData[] = $quote;
				}
				$movie->setQuotes($quotesData);
			}
		}

		return $movie;
	}
}
