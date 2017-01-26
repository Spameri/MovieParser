<?php

namespace Tests\MovieParser\IMDB\Parser;

use Tester;
use MovieParser;
use Atrox;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';


class ProcessReleaseInfo extends Tester\TestCase
{

	protected function setUp()
	{
		parent::setUp();
	}


	public function testProcessMovie()
	{
		$matcher = new MovieParser\IMDB\Matcher(new MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-release.html');

		$data = $matcher->processReleaseInfo($html);

		var_dump($data);
	}


	protected function tearDown()
	{
		parent::tearDown();
	}

}


(new ProcessReleaseInfo())->run();
