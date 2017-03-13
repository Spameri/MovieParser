<?php

namespace MovieParser\IMDB\Matcher;


class ProcessReleaseInfo
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'      => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'release' => \Atrox\Matcher::multi('//table[@id="release_dates"]/tr', [
				'country' => \Atrox\Matcher::single('td[1]/a/text()'),
				'date'    => \Atrox\Matcher::single('td[2]/text()'),
				'year'    => \Atrox\Matcher::single('td[2]/a/text()'),
				'note'    => \Atrox\Matcher::single('td[3]/text()'),
			]),
			'alias'   => \Atrox\Matcher::multi('//table[@id="akas"]/tr', [
				'country' => \Atrox\Matcher::single('td[1]/text()'),
				'name'    => \Atrox\Matcher::single('td[2]/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}