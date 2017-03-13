<?php

namespace MovieParser\IMDB\Matcher;


class ProcessConnections
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'          => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'connections' => \Atrox\Matcher::multi('//div[@id="connections_content"]/div[@class="list"]/div', [
				'id'    => \Atrox\Matcher::single('a/@href'),
				'group' => \Atrox\Matcher::single('preceding-sibling::h4[1]/text()'),
				'note'  => \Atrox\Matcher::single('descendant-or-self::text()[position() > 2]'),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}