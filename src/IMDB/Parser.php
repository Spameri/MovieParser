<?php

namespace MovieParser\IMDB;

use MovieParser;
use GuzzleHttp;

class Parser
{
	const STATUS_OK = 200;

	/** @var GuzzleHttp\Client */
	private $client;
	/** @var UrlBuilder */
	private $urlBuilder;
	/** @var Matcher */
	private $matcher;
	/** @var string */
	private $url;


	public function __construct(
		UrlBuilder $urlBuilder
		, Matcher $matcher
	) {
		$this->urlBuilder = $urlBuilder;
		$this->matcher = $matcher;
	}


	/**
	 * @param string $input Input string - id, link or whatever
	 * @param bool $full load all dependencies?
	 * @return DTO\*
	 * @throws Exception\BadResponseException
	 */
	public function get($input, $full = FALSE)
	{
		// 1. get client
		$this->setUpClient();

		// 2. build url
		$this->url = $this->urlBuilder->buildUrl($input);

		// 3. Get content
		$content = $this->client->get($this->url);
		if ($content->getStatusCode() !== self::STATUS_OK) {
			throw new MovieParser\IMDB\Exception\BadResponseException;
		}

		// 4. Process content
		$data = $this->matcher->process($content->getBody()->getContents());

		// 5. Map to entity
		$entity = $this->createEntity($data);

		if ($full) {
			// 6. Get Links
			// 7. foreach links get content
			// 8. map to entities
			foreach ($data['links'] as $link) {
				$this->loadFullCredits($link, $entity);
				$this->loadReleaseInfo($link, $entity);
				$this->loadCompanyCredits($link, $entity);
				$this->loadLocations($link, $entity);
				$this->loadTechnical($link, $entity);
				$this->loadTagLines($link, $entity);
				$this->loadPlotSummary($link, $entity);
				$this->loadTrivia($link, $entity);
				$this->loadGoofs($link, $entity);
				$this->loadCrazyCredits($link, $entity);
				$this->loadQuotes($link, $entity);
				$this->loadConnections($link, $entity);
				$this->loadImages($link, $entity);
			}
		}

		// 9. return main entity

		return $entity;
	}


	public function setUpClient()
	{
		$this->client = new GuzzleHttp\Client();
	}


	/**
	 * @param array $data
	 * @return MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series
	 */
	public function createEntity($data)
	{
		switch ($data['type']) {
			case Matcher::TYPE_SERIES:
				$entity = new MovieParser\IMDB\DTO\Series($data);
				break;

			case Matcher::TYPE_MOVIE:
			default:
				$entity = new MovieParser\IMDB\DTO\Movie($data);
				break;
		}

		return $entity;
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadTechnical($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_TECHNICAL)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_TECHNICAL);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processTechnical($content->getBody()->getContents());
				if (strpos($data['runtime'], 'hr')) {
					$exploded = explode('min', $data['runtime']);
					unset($exploded[2]);
					preg_match("/[0-9]+/", end($exploded), $runtime);
				} else {
					preg_match("/[0-9]+/", $data['runtime'], $runtime);
				}
				$entity->setRuntime($runtime[0]);
				$entity->setColor($data['color']);
				$entity->setRatio($data['ratio']);
				$entity->setCamera($data['camera']);
				$entity->setLaboratory($data['laboratory']);
				$entity->setFilmLength($data['filmLength']);
				$entity->setNegativeFormat($data['negativeFormat']);
				$entity->setCineProcess($data['cineProcess']);
				$entity->setPrinted($data['printed']);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadLocations($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_LOCATIONS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_LOCATIONS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processLocations($content->getBody()->getContents());
				$entity->setLocations($data['locations']);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 * @throws Exception\IncompleteId
	 */
	public function loadCompanyCredits($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_COMPANY_CREDITS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_COMPANY_CREDITS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processCompanyCredits($content->getBody()->getContents());
				foreach ($data['credits'] as $creditData) {
					foreach ($creditData['companies'] as $companyData) {
						$company = new MovieParser\IMDB\DTO\Company([]);
						$company->setName($companyData['companyName']);
						$company->setId('co' . $this->urlBuilder->getId($companyData['companyLink']));
						$credit = new MovieParser\IMDB\DTO\Credit();
						$credit->setCompany($company);
						$credit->setNote($companyData['companyNote']);
						$entity->addCredit($credit);
					}
				}
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadReleaseInfo($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_RELEASE_INFO)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_RELEASE_INFO);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processReleaseInfo($content->getBody()->getContents());
				foreach ($data['release'] as $releaseData) {
					$release = new MovieParser\IMDB\DTO\Release($releaseData);
					$entity->addRelease($release);
				}
				foreach ($data['alias'] as $aliasData) {
					$alias = new MovieParser\IMDB\DTO\Alias($aliasData);
					$entity->addAlias($alias);
				}
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadFullCredits($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_FULL_CREDITS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_FULL_CREDITS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processFullCredits($content->getBody()->getContents());
				foreach ($data['cast'] as $personData) {
					$role = new MovieParser\IMDB\DTO\Role();
					$role->setName('Cast');
					$role->setType('Cast');
					$role->setDescription($personData['description']);

					if ($personData['person']) {
						$person = new MovieParser\IMDB\DTO\Person();
						$person->setId(UrlBuilder::TYPE_PERSON . $this->urlBuilder->getId($personData['person']));
						$person->setName($personData['person_name']);
						$role->setPerson($person);
					}

					if ($personData['character']) {
						$character = new MovieParser\IMDB\DTO\Character();
						$character->setId(UrlBuilder::TYPE_CHARACTER . $this->urlBuilder->getId($personData['character']));
						$character->setName($personData['character_name']);
						$role->setCharacter($character);
					}

					if ($personData['alias']) {
						$alias = new MovieParser\IMDB\DTO\Character();
						$alias->setId(UrlBuilder::TYPE_CHARACTER . $this->urlBuilder->getId($personData['alias']));
						$alias->setName($personData['alias_name']);
						$role->setAlias($alias);
					}

					$entity->addPerson($role);
				}
				foreach ($data['crew'] as $crewData) {
					foreach ($crewData['people'] as $crewPerson) {
						if ( ! $crewPerson['person']) {
							continue;
						}
						$role = new MovieParser\IMDB\DTO\Role();
						$role->setName($crewData['role_name']);
						$role->setType('Crew');
						$role->setDescription($crewPerson['description']);

						$person = new MovieParser\IMDB\DTO\Person();
						$person->setId(UrlBuilder::TYPE_PERSON . $this->urlBuilder->getId($crewPerson['person']));
						$person->setName($crewPerson['person_name']);
						$role->setPerson($person);

						$entity->addPerson($role);
					}
				}
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadTagLines($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_TAG_LINE)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_TAG_LINE);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processTagLines($content->getBody()->getContents());
				$entity->setTagLines($data['tagLines']);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadPlotSummary($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_PLOT_SUMMARY)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_PLOT_SUMMARY);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processPlotSummary($content->getBody()->getContents());
				$entity->setPlotSummary($data['plotSummary']);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadSynopsis($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_SYNOPSIS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_SYNOPSIS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processSynopsis($content->getBody()->getContents());
				$synopsis = '';
				foreach ($data['synopsis'] as $item) {
					$synopsis .= str_replace(['(', ')'], '', $item);
				}
				$synopsis = str_replace('  ', ' ', $synopsis);
				$entity->setSynopsis($synopsis);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadKeywords($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_KEYWORDS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_KEYWORDS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processKeywords($content->getBody()->getContents());
				$entity->setKeyWords($data['keywords']);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadTrivia($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_TRIVIA)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_TRIVIA);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processTrivia($content->getBody()->getContents());
				$triviaData = [];
				foreach ($data['trivia'] as $value) {
					$trivia = new MovieParser\IMDB\DTO\Trivia();
					$trivia->setId($value['id']);
					$trivia->setText(implode(' ', $value['text']));
					$trivia->setVideo($entity->getId());
					preg_match("/[0-9]+/", $value['relevancy'], $relevancy);
					$trivia->setRelevancy(reset($relevancy));
					$triviaData[] = $trivia;
				}
				$entity->setTrivia($triviaData);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadGoofs($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_GOOFS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_GOOFS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processGoofs($content->getBody()->getContents());
				$goofsData = [];
				foreach ($data['goofs'] as $value) {
					$goof = new MovieParser\IMDB\DTO\Goof();
					$goof->setId($value['id']);
					$goof->setText(implode(' ', $value['text']));
					$goof->setVideo($entity->getId());
					preg_match("/[0-9]+/", $value['relevancy'], $relevancy);
					$goof->setRelevancy(reset($relevancy));
					$goofsData[] = $goof;
				}
				$entity->setGoofs($goofsData);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadCrazyCredits($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_CRAZY_CREDITS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_CRAZY_CREDITS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processCompanyCredits($content->getBody()->getContents());
				$crazyData = [];
				foreach ($data['credits'] as $value) {
					$crazyCredit = new MovieParser\IMDB\DTO\CrazyCredit();
					$crazyCredit->setId($value['id']);
					$crazyCredit->setText(implode(' ', $value['text']));
					$crazyCredit->setVideo($entity->getId());
					preg_match("/[0-9]+/", $value['relevancy'], $relevancy);
					$crazyCredit->setRelevancy(reset($relevancy));
					$crazyData[] = $crazyCredit;
				}
				$entity->setCrazyCredits($crazyData);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadQuotes($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_QUOTES)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_QUOTES);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processQuotes($content->getBody()->getContents());
				$quotesData = [];
				foreach ($data['quotes'] as $value) {
					$quote = new MovieParser\IMDB\DTO\Quote();
					$quote->setId($value['id']);
					$quote->setText(implode(' ', $value['text']));
					$quote->setVideo($entity->getId());
					preg_match("/[0-9]+/", $value['relevancy'], $relevancy);
					$quote->setRelevancy(reset($relevancy));
					$quotesData[] = $quote;
				}
				$entity->setQuotes($quotesData);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadConnections($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_MOVIE_CONNECTIONS)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_MOVIE_CONNECTIONS);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processConnections($content->getBody()->getContents());
				$connectionData = [];
				foreach ($data['connections'] as $value) {
					$connection = new MovieParser\IMDB\DTO\Connection();
					$connection->setConnection($value['id']);
					$connection->setNote(implode(' ', $value['note']));
					$connection->setType(chop($value['group'], ' '));
					$connectionData[] = $connection;
				}
				$entity->setConnections($connectionData);
			}
		}
	}


	/**
	 * @param string $link
	 * @param MovieParser\IMDB\DTO\Movie|MovieParser\IMDB\DTO\Series $entity
	 */
	public function loadImages($link, $entity)
	{
		if (strpos($link, UrlBuilder::URL_MEDIA_INDEX)) {
			$content = $this->client->get($this->url . '/' . UrlBuilder::URL_MEDIA_INDEX);
			if ($content->getStatusCode() === self::STATUS_OK) {
				$data = $this->matcher->processImages($content->getBody()->getContents());

				$entity->setImages($imageData);
			}
		}
	}
}