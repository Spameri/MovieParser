<?php
namespace MovieParser\IMDB\Matcher;


class ProcessPlotSummary
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'          	=> \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'plots' 		=> \Atrox\Matcher::multi('//ul[@id="plot-summaries-content"]/li', [
				'plotSummary' => \Atrox\Matcher::multi('./p//text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}