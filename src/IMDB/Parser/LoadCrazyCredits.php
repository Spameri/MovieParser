<?php

namespace MovieParser\IMDB\Parser;


class LoadCrazyCredits
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessCrazyCredits
	 */
	private $processCrazyCredits;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessCrazyCredits $processCrazyCredits
	)
	{
		$this->processCrazyCredits = $processCrazyCredits;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_CRAZY_CREDITS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processCrazyCredits->process($content->getBody()->getContents());
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				$crazyData = [];
				foreach ($data['credits'] as $value) {
					$crazyCredit = new \MovieParser\IMDB\DTO\CrazyCredit();
					$crazyCredit->setId($value['id']);
					$crazyCredit->setText(implode(' ', $value['text']));
					$crazyCredit->setVideo($movie->getId());
					preg_match("/[0-9]+/", $value['relevancy'], $relevancy);
					$crazyCredit->setRelevancy(reset($relevancy));
					$crazyData[] = $crazyCredit;
				}
				$movie->setCrazyCredits($crazyData);
			}
		}

		return $movie;
	}
}
