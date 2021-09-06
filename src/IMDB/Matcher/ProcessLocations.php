<?php

namespace MovieParser\IMDB\Matcher;


class ProcessLocations
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'        => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'locations' => \Atrox\Matcher::multi('//div[contains(@class, "soda sodavote")]/dt/a/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}
