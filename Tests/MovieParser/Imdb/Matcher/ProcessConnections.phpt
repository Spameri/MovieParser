<?php

namespace Tests\MovieParser\IMDB\Parser;



include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessConnections.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessConnections extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessConnections(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-connection.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::count(63, $data['connections']);

		\Tester\Assert::same($data['connections'][0]['id'], '/title/tt0371746');
		\Tester\Assert::same($data['connections'][0]['group'], 'Follows ');
		\Tester\Assert::same($data['connections'][0]['note'], NULL);
	}
}


(new ProcessConnections())->run();
