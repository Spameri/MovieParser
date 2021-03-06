<?php

namespace MovieParser\IMDB\DTO;

class Movie extends Dto
{
	/** @var string */
	private $title;
	/** @var int */
	private $year;
	/** @var int */
	private $rating;
	/** @var int */
	private $ratingCount;
	/** @var string */
	private $poster;
	/** @var string */
	private $description;
	/** @var array */
	private $genres;
	/** @var string */
	private $show;
	/** @var int */
	private $season;
	/** @var ?int */
	private $episode;
	/** @var \MovieParser\IMDB\DTO\Person[] */
	private $people;
	/** @var \MovieParser\IMDB\DTO\Release[] */
	private $release;
	/** @var \MovieParser\IMDB\DTO\Alias[] */
	private $alias;
	/** @var \MovieParser\IMDB\DTO\Credit[] */
	private $credits;
	/** @var array */
	private $locations;
	/** @var int */
	private $runtime;
	/** @var string */
	private $color;
	/** @var array */
	private $ratio;
	/** @var array */
	private $camera;
	/** @var array */
	private $laboratory;
	/** @var string */
	private $filmLength;
	/** @var string */
	private $negativeFormat;
	/** @var array */
	private $cineProcess;
	/** @var array */
	private $printed;
	/** @var array */
	private $tagLines;
	/** @var array */
	private $plotSummary;
	/** @var string */
	private $synopsis;
	/** @var array */
	private $keyWords;
	/** @var \MovieParser\IMDB\DTO\Trivia[] */
	private $trivia;
	/** @var \MovieParser\IMDB\DTO\Goof[] */
	private $goofs;
	/** @var \MovieParser\IMDB\DTO\CrazyCredit[] */
	private $crazyCredits;
	/** @var \MovieParser\IMDB\DTO\Quote[] */
	private $quotes;
	/** @var \MovieParser\IMDB\DTO\Connection[] */
	private $connections;
	/** @var \MovieParser\IMDB\DTO\Image[] */
	private $images;
	/** @var array */
	private $links;
	/**
	 * @var array
	 */
	private $alternativeVersions;

	/**
	 * @var array
	 */
	private $awards;

	/**
	 * @var array
	 */
	private $videos;


	public function __construct($data)
	{
		if (isset($data['id'])) $this->setId($data['id']);
		if (isset($data['title'])) $this->setTitle($data['title']);
		if (isset($data['year'])) $this->setYear((int) $data['year']);
		if (isset($data['rating'])) $this->setRating((int) str_replace('.', '', $data['rating']));
		if (isset($data['ratingCount'])) $this->setRatingCount((int) str_replace(',', '', $data['ratingCount']));
		if (isset($data['poster'])) $this->setPoster($data['poster']);
		if (isset($data['description'])) $this->setDescription($data['description']);
		if (isset($data['genres'])) $this->setGenres($data['genres']);
		if (isset($data['links'])) $this->setLinks($data['links']);
		if (isset($data['show'])) {
			preg_match('/\d+/', $data['show'], $output);
			$this->setShow($output[0]);
		}
		if (isset($data['season'])) {
			preg_match('/\d+/', $data['season'], $output);
			$this->setSeason($output[0]);
		}
		if (isset($data['episode'])) {
			preg_match('/\d+/', $data['episode'], $output);
			$this->setEpisode($output[0]);
		}
	}


	/**
	 * @param Credit $credit
	 */
	public function addCredit($credit)
	{
		$this->credits[] = $credit;
	}


	/**
	 * @param Role $role
	 */
	public function addPerson($role)
	{
		$this->people[] = $role;
	}


	/**
	 * @param Release $release
	 */
	public function addRelease($release)
	{
		$this->release[] = $release;
	}


	/**
	 * @return array
	 */
	public function getRelease()
	{
		return $this->release;
	}


	/**
	 * @param Alias $alias
	 */
	public function addAlias($alias)
	{
		$this->alias[] = $alias;
	}


	/**
	 * @return array
	 */
	public function getAlias()
	{
		return $this->alias;
	}


	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}


	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}


	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->year;
	}


	/**
	 * @param int $year
	 */
	public function setYear($year)
	{
		$this->year = $year;
	}


	/**
	 * @return int
	 */
	public function getRating()
	{
		return $this->rating;
	}


	/**
	 * @param int $rating
	 */
	public function setRating($rating)
	{
		$this->rating = $rating;
	}


	/**
	 * @return int
	 */
	public function getRatingCount()
	{
		return $this->ratingCount;
	}


	/**
	 * @param int $ratingCount
	 */
	public function setRatingCount($ratingCount)
	{
		$this->ratingCount = $ratingCount;
	}


	/**
	 * @return string
	 */
	public function getPoster()
	{
		return $this->poster;
	}


	/**
	 * @param string $poster
	 */
	public function setPoster($poster)
	{
		$this->poster = $poster;
	}


	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}


	/**
	 * @return array
	 */
	public function getGenres()
	{
		return $this->genres;
	}


	/**
	 * @param array $genres
	 */
	public function setGenres($genres)
	{
		$this->genres = $genres;
	}


	/**
	 * @return \MovieParser\IMDB\DTO\Person[]
	 */
	public function getPeople()
	{
		return $this->people;
	}


	/**
	 * @param array $people
	 */
	public function setPeople($people)
	{
		$this->people = $people;
	}


	/**
	 * @return array
	 */
	public function getLocations()
	{
		return $this->locations;
	}


	/**
	 * @param array $locations
	 */
	public function setLocations($locations)
	{
		$this->locations = $locations;
	}


	/**
	 * @return int
	 */
	public function getRuntime()
	{
		return $this->runtime;
	}


	/**
	 * @param int $runtime
	 */
	public function setRuntime($runtime)
	{
		$this->runtime = $runtime;
	}


	/**
	 * @return string
	 */
	public function getColor()
	{
		return $this->color;
	}


	/**
	 * @param string $color
	 */
	public function setColor($color)
	{
		$this->color = $color;
	}


	/**
	 * @return array
	 */
	public function getRatio()
	{
		return $this->ratio;
	}


	/**
	 * @param array $ratio
	 */
	public function setRatio($ratio)
	{
		$this->ratio = $ratio;
	}


	/**
	 * @return array
	 */
	public function getCamera()
	{
		return $this->camera;
	}


	/**
	 * @param array $camera
	 */
	public function setCamera($camera)
	{
		$this->camera = $camera;
	}


	/**
	 * @return array
	 */
	public function getLaboratory()
	{
		return $this->laboratory;
	}


	/**
	 * @param array $laboratory
	 */
	public function setLaboratory($laboratory)
	{
		$this->laboratory = $laboratory;
	}


	/**
	 * @return string
	 */
	public function getFilmLength()
	{
		return $this->filmLength;
	}


	/**
	 * @param string $filmLength
	 */
	public function setFilmLength($filmLength)
	{
		$this->filmLength = $filmLength;
	}


	/**
	 * @return string
	 */
	public function getNegativeFormat()
	{
		return $this->negativeFormat;
	}


	/**
	 * @param string $negativeFormat
	 */
	public function setNegativeFormat($negativeFormat)
	{
		$this->negativeFormat = $negativeFormat;
	}


	/**
	 * @return array
	 */
	public function getCineProcess()
	{
		return $this->cineProcess;
	}


	/**
	 * @param array $cineProcess
	 */
	public function setCineProcess($cineProcess)
	{
		$this->cineProcess = $cineProcess;
	}


	/**
	 * @return array
	 */
	public function getPrinted()
	{
		return $this->printed;
	}


	/**
	 * @param array $printed
	 */
	public function setPrinted($printed)
	{
		$this->printed = $printed;
	}


	/**
	 * @return array
	 */
	public function getTagLines()
	{
		return $this->tagLines;
	}


	/**
	 * @param array $tagLines
	 */
	public function setTagLines($tagLines)
	{
		$this->tagLines = $tagLines;
	}


	/**
	 * @return array
	 */
	public function getPlotSummary()
	{
		return $this->plotSummary;
	}


	/**
	 * @param array $plotSummary
	 */
	public function setPlotSummary($plotSummary)
	{
		$this->plotSummary = $plotSummary;
	}


	/**
	 * @return string
	 */
	public function getSynopsis()
	{
		return $this->synopsis;
	}


	/**
	 * @param string $synopsis
	 */
	public function setSynopsis($synopsis)
	{
		$this->synopsis = $synopsis;
	}


	/**
	 * @return array
	 */
	public function getKeyWords()
	{
		return $this->keyWords;
	}


	/**
	 * @param array $keyWords
	 */
	public function setKeyWords($keyWords)
	{
		$this->keyWords = $keyWords;
	}


	/**
	 * @return array
	 */
	public function getTrivia()
	{
		return $this->trivia;
	}


	/**
	 * @param array $trivia
	 */
	public function setTrivia($trivia)
	{
		$this->trivia = $trivia;
	}


	/**
	 * @return array
	 */
	public function getGoofs()
	{
		return $this->goofs;
	}


	/**
	 * @param array $goofs
	 */
	public function setGoofs($goofs)
	{
		$this->goofs = $goofs;
	}


	/**
	 * @return \MovieParser\IMDB\DTO\CrazyCredit[]
	 */
	public function getCrazyCredits()
	{
		return $this->crazyCredits;
	}


	/**
	 * @param array $crazyCredits
	 */
	public function setCrazyCredits($crazyCredits)
	{
		$this->crazyCredits = $crazyCredits;
	}


	/**
	 * @return array
	 */
	public function getQuotes()
	{
		return $this->quotes;
	}


	/**
	 * @param array $quotes
	 */
	public function setQuotes($quotes)
	{
		$this->quotes = $quotes;
	}


	/**
	 * @return \MovieParser\IMDB\DTO\Connection[]
	 */
	public function getConnections()
	{
		return $this->connections;
	}


	/**
	 * @param array $connections
	 */
	public function setConnections($connections)
	{
		$this->connections = $connections;
	}


	/**
	 * @return array
	 */
	public function getImages()
	{
		return $this->images;
	}


	/**
	 * @param array $images
	 */
	public function setImages($images)
	{
		$this->images = $images;
	}


	/**
	 * @return \MovieParser\IMDB\DTO\Credit[]
	 */
	public function getCredits() : array
	{
		return $this->credits;
	}


	/**
	 * @param array $credits
	 */
	public function setCredits(array $credits)
	{
		$this->credits = $credits;
	}


	/**
	 * @return array
	 */
	public function getLinks() : array
	{
		return $this->links;
	}


	/**
	 * @param array $links
	 */
	public function setLinks(array $links)
	{
		$this->links = $links;
	}


	/**
	 * @return array
	 */
	public function getAlternativeVersions() : array
	{
		return $this->alternativeVersions;
	}


	/**
	 * @param array $alternativeVersions
	 */
	public function setAlternativeVersions(array $alternativeVersions)
	{
		$this->alternativeVersions = $alternativeVersions;
	}


	/**
	 * @return array
	 */
	public function getAwards() : array
	{
		return $this->awards;
	}


	/**
	 * @param array $awards
	 */
	public function setAwards(array $awards)
	{
		$this->awards = $awards;
	}


	/**
	 * @return array
	 */
	public function getVideos() : array
	{
		return $this->videos;
	}


	/**
	 * @param array $videos
	 */
	public function setVideos(array $videos)
	{
		$this->videos = $videos;
	}


	/**
	 * @return string
	 */
	public function getShow() : string
	{
		return $this->show;
	}


	/**
	 * @param string $show
	 */
	public function setShow(string $show)
	{
		$this->show = $show;
	}


	/**
	 * @return int
	 */
	public function getSeason() : int
	{
		return $this->season;
	}


	/**
	 * @param int $season
	 */
	public function setSeason(int $season)
	{
		$this->season = $season;
	}


	/**
	 * @return ?int
	 */
	public function getEpisode() : ?int
	{
		return $this->episode;
	}


	/**
	 * @param ?int $episode
	 */
	public function setEpisode(?int $episode)
	{
		$this->episode = $episode;
	}
}