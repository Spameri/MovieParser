<?php

namespace MovieParser\IMDB\Matcher;


class ProcessVideo
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'videoObject' => \Atrox\Matcher::single('//body/script[1]/text()'),
		])
			->fromHtml();

		$data = $match($response);

		$videoData = str_replace([
			'window.IMDbReactInitialState = window.IMDbReactInitialState || [];',
			'window.IMDbReactInitialState.push(',
			');',
		],
			'',
			$data['videoObject']
		);
		$data['videoObject'] = $videoData;

		return $data;
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
