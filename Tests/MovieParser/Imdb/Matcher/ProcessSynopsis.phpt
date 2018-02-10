<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessSynopsis.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';


class ProcessSynopsis extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessSynopsis();

		$html = file_get_contents(__DIR__ . '/AntMan-synopsis.html');

		$data = $matcher->process($html);

		var_dump($data['synopsis']);
		\Tester\Assert::same(8692, \strlen($data['synopsis']));
	}

}


(new ProcessSynopsis())->run();
