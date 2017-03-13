<?php

namespace MovieParser\IMDB\Matcher;


class ProcessKeywords
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'       => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'keywords' => \Atrox\Matcher::multi('//table[@class="dataTable evenWidthTable2Col"]/tbody/tr/td[1]/div/a/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}