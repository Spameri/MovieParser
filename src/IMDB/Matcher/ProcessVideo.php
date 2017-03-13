<?php

namespace MovieParser\IMDB\Matcher;


class ProcessVideo
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'videoObject' => \Atrox\Matcher::single('//iframe[@id="video-player-container"]/@src'),
			'description' => \Atrox\Matcher::multi('//table[@id="video-details"]/tr', [
				'title'       => \Atrox\Matcher::single('td/strong/text()'),
				'description' => \Atrox\Matcher::single('td[2]/span/text()'),
				'links'       => \Atrox\Matcher::single('td[2]/a/@href'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	public function processObject(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'videoObject' => \Atrox\Matcher::single('//script[@class="imdb-player-data"]/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}
