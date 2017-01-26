<?php

namespace Tests\MovieParser\IMDB\Parser;

use Tester;
use MovieParser;
use Atrox;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Parser.php';
include __DIR__ . '/../../../../src/IMDB/Matcher.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Release.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Alias.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Credit.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Company.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Trivia.php';


class Get extends Tester\TestCase
{

	protected function setUp()
	{
		parent::setUp();
	}


	public function testSuccessFullGet()
	{
		$parser = new MovieParser\IMDB\Parser(new MovieParser\IMDB\UrlBuilder(), new MovieParser\IMDB\Matcher(new MovieParser\IMDB\UrlBuilder()));

		$entity = $parser->get('http://www.imdb.com/title/tt0478970/', TRUE);

		var_dump($entity);
	}


	protected function tearDown()
	{
		parent::tearDown();
	}

}
(new Get())->run();
