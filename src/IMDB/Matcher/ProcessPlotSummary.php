<?php
namespace MovieParser\IMDB\Matcher;


class ProcessPlotSummary
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'          => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'plotSummary' => \Atrox\Matcher::multi('//ul[@class="zebraList"]/li/p/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}