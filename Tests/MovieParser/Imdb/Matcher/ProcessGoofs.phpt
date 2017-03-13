<?php

namespace Tests\MovieParser\IMDB\Parser;

include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessGoofs.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessGoofs extends \Tester\TestCase
{
	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessGoofs(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-goofs.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::count(27, $data['goofs']);
		\Tester\Assert::same('gf2564130', $data['goofs'][0]['id']);
	}
}

(new ProcessGoofs())->run();
