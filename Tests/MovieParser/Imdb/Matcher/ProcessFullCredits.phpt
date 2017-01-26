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


class ProcessFullCredits extends Tester\TestCase
{

	protected function setUp()
	{
		parent::setUp();
	}


	public function testProcessMovie()
	{
		$matcher = new MovieParser\IMDB\Matcher(new MovieParser\IMDB\UrlBuilder());
		$urlBuilder = new MovieParser\IMDB\UrlBuilder();

		$html = file_get_contents(__DIR__ . '/AntMan-fullcredits.html');

		$data = $matcher->processFullCredits($html);
		$entity = new MovieParser\IMDB\DTO\Movie([]);
		foreach ($data['cast'] as $personData) {
			$role = new MovieParser\IMDB\DTO\Role();
			$role->setName('Cast');
			$role->setType('Cast');
			$role->setDescription($personData['description']);

			if ($personData['person']) {
				$person = new MovieParser\IMDB\DTO\Person();
				$person->setId($urlBuilder->getId($personData['person']));
				$person->setName($personData['person_name']);
				$role->setPerson($person);
			};

			if ($personData['character']) {
				$character = new MovieParser\IMDB\DTO\Character();
				$character->setId($urlBuilder->getId($personData['character']));
				$character->setName($personData['character_name']);
				$role->setCharacter($character);
			}

			if ($personData['alias']) {
				$alias = new MovieParser\IMDB\DTO\Character();
				$alias->setId($urlBuilder->getId($personData['alias']));
				$alias->setName($personData['alias_name']);
				$role->setAlias($alias);
			}

			$entity->addPerson($role);
		}
		foreach ($data['crew'] as $crewData) {
			foreach ($crewData['people'] as $crewPerson) {
				if ( ! $crewPerson['person']) continue;
				$role = new MovieParser\IMDB\DTO\Role();
				$role->setName($crewData['role_name']);
				$role->setType('Crew');
				$role->setDescription($crewPerson['description']);

				$person = new MovieParser\IMDB\DTO\Person();
				$person->setId($urlBuilder->getId($crewPerson['person']));
				$person->setName($crewPerson['person_name']);
				$role->setPerson($person);

				$entity->addPerson($role);
			}
		}
		var_dump($entity);
	}


	protected function tearDown()
	{
		parent::tearDown();
	}

}


(new ProcessFullCredits())->run();
