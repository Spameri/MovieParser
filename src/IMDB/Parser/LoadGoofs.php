<?php

namespace MovieParser\IMDB\Parser;


class LoadGoofs
{
	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessGoofs
	 */
	private $processGoofs;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessGoofs $processGoofs
	)
	{
		$this->processGoofs = $processGoofs;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_GOOFS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processGoofs->process($content->getBody()->getContents());
				$goofsData = [];
				foreach ($data['goofs'] as $value) {
					$goof = new \MovieParser\IMDB\DTO\Goof();
					$goof->setId($value['id']);
					$goof->setText(implode(' ', $value['text']));
					$goof->setVideo($movie->getId());
					preg_match('/\d+/', $value['relevancy'], $relevancy);
					$goof->setRelevancy(reset($relevancy));
					$goofsData[] = $goof;
				}
				$movie->setGoofs($goofsData);
			}
		}

		return $movie;
	}
}