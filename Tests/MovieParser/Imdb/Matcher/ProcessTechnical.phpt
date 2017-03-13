<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessTechnical.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';


class ProcessTechnical extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessTechnical(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-technical.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::same($data['runtime'], '1 hr 57 min (117 min)');
		\Tester\Assert::count(4, $data['camera']);
	}

}


(new ProcessTechnical())->run();
