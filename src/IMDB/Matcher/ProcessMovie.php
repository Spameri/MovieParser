<?php

namespace MovieParser\IMDB\Matcher;


class ProcessMovie
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::multi([
			'id'          => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'title'       => \Atrox\Matcher::single('//h1/text()'),
			'year'        => \Atrox\Matcher::single('//span[@id="titleYear"]/a/text()'),
			'rating'      => \Atrox\Matcher::single('//span[@itemprop="ratingValue"]/text()'),
			'ratingCount' => \Atrox\Matcher::single('//span[@itemprop="ratingCount"]/text()'),
			'poster'      => \Atrox\Matcher::single('//div[@class="poster"]/a/img/@src'),
			'description' => \Atrox\Matcher::single('//div[@class="summary_text"]/text()'),
			'genres'      => \Atrox\Matcher::multi('//h4[contains(text(), "Genres")]/following-sibling::a/text()'),
			'links'       => \Atrox\Matcher::multi('//div[@class="quicklinkSectionItem"]/a[@class="quicklink"]/@href'),

			'season' => \Atrox\Matcher::single('//div[@class="button_panel navigation_panel"]/div/div/div/div/text()[1]'),
			'episode' => \Atrox\Matcher::single('//div[@class="button_panel navigation_panel"]/div/div/div/div/text()[2]'),
			'show' => \Atrox\Matcher::single('//div[@class="titleParent"]/a/@href'),
		])
			->fromHtml();

		return $match($response);
	}
}
