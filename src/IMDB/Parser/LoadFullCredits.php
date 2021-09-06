<?php

namespace MovieParser\IMDB\Parser;


class LoadFullCredits
{

	/**
	 * @var \MovieParser\IMDB\UrlBuilder
	 */
	private $urlBuilder;

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessFullCredits
	 */
	private $processFullCredits;


	public function __construct(
		\MovieParser\IMDB\UrlBuilder $urlBuilder
		, \MovieParser\IMDB\Matcher\ProcessFullCredits $processFullCredits
	)
	{
		$this->processFullCredits = $processFullCredits;
		$this->urlBuilder = $urlBuilder;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_FULL_CREDITS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processFullCredits->process($content->getBody()->getContents());
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				foreach ($data['cast'] as $personData) {
					$role = new \MovieParser\IMDB\DTO\Role();
					$role->setName('Cast');
					$role->setType('Cast');
					$role->setDescription($personData['description']);

					if ($personData['person']) {
						$person = new \MovieParser\IMDB\DTO\Person();
						$person->setId(\MovieParser\IMDB\UrlBuilder::TYPE_PERSON . $this->urlBuilder->getId($personData['person']));
						$person->setName($personData['person_name']);
						$role->setPerson($person);
					}

					if ($personData['character']) {
						$character = new \MovieParser\IMDB\DTO\Character();
						$character->setId(\MovieParser\IMDB\UrlBuilder::TYPE_CHARACTER . $this->urlBuilder->getId($personData['character']));
						$character->setName($personData['character_name']);
						$role->setCharacter($character);
					}

					if ($personData['alias']) {
						$alias = new \MovieParser\IMDB\DTO\Character();
						$alias->setId(\MovieParser\IMDB\UrlBuilder::TYPE_CHARACTER . $this->urlBuilder->getId($personData['alias']));
						$alias->setName($personData['alias_name']);
						$role->setAlias($alias);
					}
					if ($personData['alias'] || $personData['character'] || $personData['person']) {
						$movie->addPerson($role);
					}
				}
				foreach ($data['crew'] as $crewData) {
					foreach ($crewData['people'] as $crewPerson) {
						if ( ! $crewPerson['person']) {
							continue;
						}
						$role = new \MovieParser\IMDB\DTO\Role();
						$role->setName($crewData['role_name']);
						$role->setType('Crew');
						$role->setDescription($crewPerson['description']);

						$person = new \MovieParser\IMDB\DTO\Person();
						$person->setId(\MovieParser\IMDB\UrlBuilder::TYPE_PERSON . $this->urlBuilder->getId($crewPerson['person']));
						$person->setName($crewPerson['person_name']);
						$role->setPerson($person);

						$movie->addPerson($role);
					}
				}
			}
		}

		return $movie;
	}
}
