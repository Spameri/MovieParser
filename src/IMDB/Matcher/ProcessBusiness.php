<?php

namespace MovieParser\IMDB\Matcher;


class ProcessBusiness
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'      => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
		])
			->fromHtml();

		return $match($response);
	}
}
