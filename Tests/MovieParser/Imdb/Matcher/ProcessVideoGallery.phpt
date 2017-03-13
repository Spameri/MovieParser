<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessVideoGallery.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessVideoGallery extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessVideoGallery(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-videoGallery.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('tt0478970', $data['id']);
		\Tester\Assert::count(30, $data['videos']);
		\Tester\Assert::count(2, $data['pages']);
	}

}


(new ProcessVideoGallery())->run();
