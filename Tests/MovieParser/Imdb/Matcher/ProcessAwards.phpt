<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessAwards.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessAwards extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessAwards(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-awards.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('tt0478970', $data['id']);
		\Tester\Assert::count(21, $data['awards']);
		\Tester\Assert::same('Academy of Science Fiction, Fantasy & Horror Films, USA', $data['awards'][1]['event']);
		\Tester\Assert::same('Won', $data['awards'][1]['status']);
		\Tester\Assert::same('Saturn Award', $data['awards'][1]['award']);
		\Tester\Assert::count(6 , $data['awards'][1]['category']);
		\Tester\Assert::same('Best Director', $data['awards'][1]['category'][1]['name']);
		\Tester\Assert::count(1, $data['awards'][1]['category'][1]['people']);
		\Tester\Assert::same('/name/nm0715636?ref_=ttawd_awd_3', $data['awards'][1]['category'][1]['people'][0]);
	}

}


(new ProcessAwards())->run();
