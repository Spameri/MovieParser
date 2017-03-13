<?php

namespace MovieParser\IMDB\Matcher;


class ProcessTechnical
{

	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'             => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'runtime'        => \Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Runtime")]/following-sibling::td/text()'),
			'color'          => \Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Color")]/following-sibling::td/a/text()'),
			'ratio'          => \Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Aspect Ratio")]/following-sibling::td/text()'),
			'camera'         => \Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Camera")]/following-sibling::td/text()'),
			'laboratory'     => \Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Laboratory")]/following-sibling::td/text()'),
			'filmLength'     => \Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Film Length")]/following-sibling::td/text()'),
			'negativeFormat' => \Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Negative Format")]/following-sibling::td/text()'),
			'cineProcess'    => \Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Cinematographic Process")]/following-sibling::td/text()'),
			'printed'        => \Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Printed Film Format")]/following-sibling::td/text()'),
		])
			->fromHtml();

		return $match($response);
	}
}