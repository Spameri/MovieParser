<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessCompanyCredits.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';


class ProcessCompanyCredits extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessCompanyCredits(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-companyCredits.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::same($data['credits'][1]['name'], 'Distributors');
		\Tester\Assert::count(25, $data['credits'][1]['companies']);
		\Tester\Assert::count(4, $data['credits']);
	}
}


(new ProcessCompanyCredits())->run();
