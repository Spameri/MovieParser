<?php
namespace MovieParser\IMDB\Parser;


class LoadPlotSummary
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessPlotSummary
	 */
	private $processPlotSummary;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessPlotSummary $processPlotSummary
	)
	{
		$this->processPlotSummary = $processPlotSummary;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_PLOT_SUMMARY)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processPlotSummary->process($content->getBody()->getContents());
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				$summaryData = [];
				foreach ($data['plots'] as $summary) {
					$summaryData[] = \implode(' ', $summary['plotSummary']);
				}
				$movie->setPlotSummary($summaryData);
			}
		}

		return $movie;
	}
}