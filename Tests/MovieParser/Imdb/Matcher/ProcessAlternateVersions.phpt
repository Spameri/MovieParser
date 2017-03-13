<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessAlternativeVersions.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessAlternateVersions extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessAlternativeVersions(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/BvS-alternate.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('tt2975590', $data['id']);
		\Tester\Assert::count(3, $data['alternate']);
	}

}


(new ProcessAlternateVersions())->run();
