<?php

namespace MovieParser\IMDB\Matcher;


class ProcessGoofs
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'    => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'goofs' => \Atrox\Matcher::multi('//div[@id="goofs_content"]/div[@class="list"]/div', [
				'id'        => \Atrox\Matcher::single('@id'),
				'text'      => \Atrox\Matcher::multi('div[@class="sodatext"]/descendant-or-self::text()'),
				'relevancy' => \Atrox\Matcher::single('div[@class="did-you-know-actions"]/a/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}
