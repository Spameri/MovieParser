<?php

namespace Tests\MovieParser\IMDB\Parser;

use Tester;
use MovieParser;
use Atrox;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessMedia extends Tester\TestCase
{

	protected function setUp()
	{
		parent::setUp();
	}


	public function testProcessMovie()
	{
		$matcher = new MovieParser\IMDB\Matcher(new MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-media.html');

		$data = $matcher->processMedia($html);

		var_dump($data);
	}


	protected function tearDown()
	{
		parent::tearDown();
	}

}


(new ProcessMedia())->run();
