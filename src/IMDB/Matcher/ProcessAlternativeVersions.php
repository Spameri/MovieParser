<?php

namespace MovieParser\IMDB\Matcher;


class ProcessAlternativeVersions
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'      => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'alternate' => \Atrox\Matcher::multi('//div[@id="alternateversions_content"]/div/text()')
		])
			->fromHtml();

		return $match($response);
	}
}
