<?php

namespace MovieParser\IMDB\Matcher;


class ProcessVideoGallery
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'     => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'videos' => \Atrox\Matcher::multi('//div[@class="search-results"]/ol/li/div/a/@data-video'),
			'pages' => \Atrox\Matcher::multi('//div[@id="video_gallery_content"]/div[@class="pagination video-search-navigation"][1]'
				. '/span[@class="pagination"]/span[@class="pagination"]/a/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}