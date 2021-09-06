<?php

namespace MovieParser\IMDB\Matcher;


class ProcessMedia
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'         => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'media'      => \Atrox\Matcher::multi('//div[@id="media_index_thumbnail_grid"]/a', [
				'link'  => \Atrox\Matcher::single('@href'),
				'title' => \Atrox\Matcher::single('@title'),
			]),
			'mediaTypes' => \Atrox\Matcher::multi('//div[@id="media_index_type_filters"]/ul/li/a/@href'),
			'pages'      => \Atrox\Matcher::multi('//div[@class="media_index_pagination leftright"][1]/div[@id="right"]/span/a/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}
