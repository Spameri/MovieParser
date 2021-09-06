<?php
namespace MovieParser\IMDB\Matcher;

class ProcessSynopsis
{
	public function process(string $response) : array
	{
		$match = \Atrox\Matcher::single([
			'id'       => \Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'synopsis' => \Atrox\Matcher::multi('//ul[@id="plot-synopsis-content"]/li/text()'),
		])
			->fromHtml();

		$data = $match($response);

		$data['synopsis'] = str_replace([' ()', '  ', '	', "\n"], '', implode('', $data['synopsis']));

		return $data;
	}
}
