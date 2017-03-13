<?php

namespace Tests\MovieParser\IMDB\Parser;

include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessKeywords.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';


class ProcessKeyWords extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessKeywords(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-keyWords.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::count(127, $data['keywords']);
		\Tester\Assert::same('sabotage', $data['keywords'][0]);
	}
}


(new ProcessKeyWords())->run();
