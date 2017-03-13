<?php

namespace MovieParser\IMDB\Matcher;

class ProcessFullCredits
{
	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'   => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'cast' => \Atrox\Matcher::multi('//table[@class="cast_list"]/tr', [
				'person'         => \Atrox\Matcher::single('./td[1]/a/@href'),
				'person_name'    => \Atrox\Matcher::single('.//span[@itemprop="name"]'),
				'character'      => \Atrox\Matcher::single('./td[@class="character"]/div/a[1]/@href'),
				'character_name' => \Atrox\Matcher::single('./td[@class="character"]/div/a[1]'),
				'alias'          => \Atrox\Matcher::single('./td[@class="character"]/div/a[2]/@href'),
				'alias_name'     => \Atrox\Matcher::single('./td[@class="character"]/div/a[2]'),
				'description'    => \Atrox\Matcher::single('./td[@class="character"]/div/text()[last()]'),
			]),
			'crew' => \Atrox\Matcher::multi('//h4[@class="dataHeaderWithBorder"]', [
				'role_name' => \Atrox\Matcher::single('./text()'),
				'people'    => \Atrox\Matcher::multi('following-sibling::table[@class="simpleTable simpleCreditsTable"][1]/tbody/tr', [
					'person'      => \Atrox\Matcher::single('./td[1]/a/@href'),
					'person_name' => \Atrox\Matcher::single('./td[1]/a/text()'),
					'description' => \Atrox\Matcher::single('./td[3]/text()'),
				]),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}