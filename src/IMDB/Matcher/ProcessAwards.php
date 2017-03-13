<?php

namespace MovieParser\IMDB\Matcher;


class ProcessAwards
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'     => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'awards' => \Atrox\Matcher::multi('//div[@class="article listo"]/h3', [
				'event' => \Atrox\Matcher::single('text()'),
				'status' => \Atrox\Matcher::single('following-sibling::table/tr/td/b/text()'),
				'award' => \Atrox\Matcher::single('following-sibling::table/tr/td/span/text()'),
				'category' => \Atrox\Matcher::multi('following-sibling::table[1]/tr/td[@class="award_description"]', [
					'name' => \Atrox\Matcher::single('text()'),
					'people' => \Atrox\Matcher::multi('a/@href'),
				]),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}