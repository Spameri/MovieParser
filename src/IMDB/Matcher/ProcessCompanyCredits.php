<?php

namespace MovieParser\IMDB\Matcher;


class ProcessCompanyCredits
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'      => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'credits' => \Atrox\Matcher::multi('//h4[@class="dataHeaderWithBorder"]', [
				'name'      => \Atrox\Matcher::single('text()'),
				'companies' => \Atrox\Matcher::multi('following-sibling::ul[1]/li', [
					'companyName' => \Atrox\Matcher::single('a/text()'),
					'companyLink' => \Atrox\Matcher::single('a/@href'),
					'companyNote' => \Atrox\Matcher::single('text()[last()]'),
				]),
			]),
		])
			->fromHtml();

		return $match($response);
	}
}
