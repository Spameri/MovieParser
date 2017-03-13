<?php
namespace MovieParser\IMDB\Matcher;

class ProcessSynopsis
{
	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'       => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'synopsis' => \Atrox\Matcher::multi('//div[@id="swiki.2.1"]/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}