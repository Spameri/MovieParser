<?php

namespace MovieParser\IMDB\Matcher;


class ProcessImage
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'        => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'imageData' => \Atrox\Matcher::single('//script[@id="__NEXT_DATA__"]/text()'),
		])
			->fromHtml();

		$data = $match($response);

		$imageData = str_replace([
			'window.IMDbReactInitialState = window.IMDbReactInitialState || [];',
			'window.IMDbReactInitialState.push(',
			');',
		],
			'',
			$data['imageData']
		);
		$data['imageData'] = str_replace("'mediaviewer'", '"mediaviewer"', $imageData);

		return $data;
	}
}
