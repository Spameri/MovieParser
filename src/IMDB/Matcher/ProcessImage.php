<?php

namespace MovieParser\IMDB\Matcher;


class ProcessImage
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'        => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'imageData' => \Atrox\Matcher::single('//script[@id="imageJson"]/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}