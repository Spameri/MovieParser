<?php
namespace MovieParser\IMDB\Parser;


class LoadSynopsis
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessSynopsis
	 */
	private $processSynopsis;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessSynopsis $processSynopsis
	)
	{
		$this->processSynopsis = $processSynopsis;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_SYNOPSIS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processSynopsis->process($content->getBody()->getContents());
				$movie->setPlotSummary($data['plotSummary']);
			}
		}

		return $movie;
	}
}
