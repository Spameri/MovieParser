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
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_TECHNICAL)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processLocations->process($content->getBody()->getContents());
				if (strpos($data['runtime'], 'hr')) {
					$exploded = explode('min', $data['runtime']);
					unset($exploded[2]);
					preg_match('/\d+/', end($exploded), $runtime);
				} else {
					preg_match('/\d+/', $data['runtime'], $runtime);
				}
				$movie->setRuntime($runtime[0]);
				$movie->setColor($data['color']);
				$movie->setRatio($data['ratio']);
				$movie->setCamera($data['camera']);
				$movie->setLaboratory($data['laboratory']);
				$movie->setFilmLength($data['filmLength']);
				$movie->setNegativeFormat($data['negativeFormat']);
				$movie->setCineProcess($data['cineProcess']);
				$movie->setPrinted($data['printed']);
			}
		}

		return $movie;
	}
}