<?php
namespace MovieParser\IMDB\Matcher;


class ProcessTagLines
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'       => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'tagLines' => \Atrox\Matcher::multi('//div[@id="taglines_content"]/div[contains(@class, "soda")]/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}
