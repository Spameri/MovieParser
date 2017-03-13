<?php

namespace MovieParser\IMDB;


class Parser
{
	const STATUS_OK = 200;

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $client;

	/**
	 * @var UrlBuilder
	 */
	private $urlBuilder;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var \MovieParser\IMDB\Parser\LoadMovie
	 */
	private $loadMovie;
	/** @var \MovieParser\IMDB\Parser\LoadAlternativeVersions */
	private $loadAlternativeVersions;
	/** @var \MovieParser\IMDB\Parser\LoadAwards */
	private $loadAwards;
	/** @var \MovieParser\IMDB\Parser\LoadBusiness */
	private $loadBusiness;
	/** @var \MovieParser\IMDB\Parser\LoadCompanyCredits */
	private $loadCompanyCredits;
	/** @var \MovieParser\IMDB\Parser\LoadConnections */
	private $loadConnections;
	/** @var \MovieParser\IMDB\Parser\LoadCrazyCredits */
	private $loadCrazyCredits;
	/** @var \MovieParser\IMDB\Parser\LoadFullCredits */
	private $loadFullCredits;
	/** @var \MovieParser\IMDB\Parser\LoadGoofs */
	private $loadGoofs;
	/** @var \MovieParser\IMDB\Parser\LoadKeywords */
	private $loadKeywords;
	/** @var \MovieParser\IMDB\Parser\LoadLocations */
	private $loadLocations;
	/** @var \MovieParser\IMDB\Parser\LoadMedia */
	private $loadMedia;
	/** @var \MovieParser\IMDB\Parser\LoadPlotSummary */
	private $loadPlotSummary;
	/** @var \MovieParser\IMDB\Parser\LoadQuotes */
	private $loadQuotes;
	/** @var \MovieParser\IMDB\Parser\LoadRatings */
	private $loadRatings;
	/** @var \MovieParser\IMDB\Parser\LoadReleaseInfo */
	private $loadReleaseInfo;
	/** @var \MovieParser\IMDB\Parser\LoadReviews */
	private $loadReviews;
	/** @var \MovieParser\IMDB\Parser\LoadSoundtrack */
	private $loadSoundtrack;
	/** @var \MovieParser\IMDB\Parser\LoadSynopsis */
	private $loadSynopsis;
	/** @var \MovieParser\IMDB\Parser\LoadTagLines */
	private $loadTagLines;
	/** @var \MovieParser\IMDB\Parser\LoadTechnical */
	private $loadTechnical;
	/** @var \MovieParser\IMDB\Parser\LoadTrivia */
	private $loadTrivia;
	/** @var \MovieParser\IMDB\Parser\LoadVideoGallery */
	private $loadVideoGallery;


	public function __construct(
		UrlBuilder $urlBuilder
		, \MovieParser\IMDB\Parser\LoadMovie $loadMovie
		, \MovieParser\IMDB\Parser\LoadAlternativeVersions $loadAlternativeVersions
		, \MovieParser\IMDB\Parser\LoadAwards $loadAwards
		, \MovieParser\IMDB\Parser\LoadBusiness $loadBusiness
		, \MovieParser\IMDB\Parser\LoadCompanyCredits $loadCompanyCredits
		, \MovieParser\IMDB\Parser\LoadConnections $loadConnections
		, \MovieParser\IMDB\Parser\LoadCrazyCredits $loadCrazyCredits
		, \MovieParser\IMDB\Parser\LoadFullCredits $loadFullCredits
		, \MovieParser\IMDB\Parser\LoadGoofs $loadGoofs
		, \MovieParser\IMDB\Parser\LoadKeywords $loadKeywords
		, \MovieParser\IMDB\Parser\LoadLocations $loadLocations
		, \MovieParser\IMDB\Parser\LoadMedia $loadMedia
		, \MovieParser\IMDB\Parser\LoadPlotSummary $loadPlotSummary
		, \MovieParser\IMDB\Parser\LoadQuotes $loadQuotes
		, \MovieParser\IMDB\Parser\LoadRatings $loadRatings
		, \MovieParser\IMDB\Parser\LoadReleaseInfo $loadReleaseInfo
		, \MovieParser\IMDB\Parser\LoadReviews $loadReviews
		, \MovieParser\IMDB\Parser\LoadSoundtrack $loadSoundtrack
		, \MovieParser\IMDB\Parser\LoadSynopsis $loadSynopsis
		, \MovieParser\IMDB\Parser\LoadTagLines $loadTagLines
		, \MovieParser\IMDB\Parser\LoadTechnical $loadTechnical
		, \MovieParser\IMDB\Parser\LoadTrivia $loadTrivia
		, \MovieParser\IMDB\Parser\LoadVideoGallery $loadVideoGallery
	) {
		$this->client = new \GuzzleHttp\Client();
		$this->urlBuilder = $urlBuilder;
		$this->loadMovie = $loadMovie;
		$this->loadAlternativeVersions = $loadAlternativeVersions;
		$this->loadAwards = $loadAwards;
		$this->loadBusiness = $loadBusiness;
		$this->loadCompanyCredits = $loadCompanyCredits;
		$this->loadConnections = $loadConnections;
		$this->loadCrazyCredits = $loadCrazyCredits;
		$this->loadFullCredits = $loadFullCredits;
		$this->loadGoofs = $loadGoofs;
		$this->loadKeywords = $loadKeywords;
		$this->loadLocations = $loadLocations;
		$this->loadMedia = $loadMedia;
		$this->loadPlotSummary = $loadPlotSummary;
		$this->loadQuotes = $loadQuotes;
		$this->loadRatings = $loadRatings;
		$this->loadReleaseInfo = $loadReleaseInfo;
		$this->loadReviews = $loadReviews;
		$this->loadSoundtrack = $loadSoundtrack;
		$this->loadSynopsis = $loadSynopsis;
		$this->loadTagLines = $loadTagLines;
		$this->loadTechnical = $loadTechnical;
		$this->loadTrivia = $loadTrivia;
		$this->loadVideoGallery = $loadVideoGallery;
	}

	public function get(string $input) : \MovieParser\IMDB\DTO\Movie
	{
		$this->setUpUrl($input);

		$movie = $this->loadMovie->load($this->getUrl());
		$this->loadAlternativeVersions->load($this->getUrl(UrlBuilder::URL_ALTERNATE), $movie);
		$this->loadAwards->load($this->getUrl(UrlBuilder::URL_AWARDS), $movie);
		$this->loadBusiness->load($this->getUrl(UrlBuilder::URL_BUSINESS), $movie);
		$this->loadCompanyCredits->load($this->getUrl(UrlBuilder::URL_COMPANY_CREDITS), $movie);
		$this->loadConnections->load($this->getUrl(UrlBuilder::URL_MOVIE_CONNECTIONS), $movie);
		$this->loadCrazyCredits->load($this->getUrl(UrlBuilder::URL_CRAZY_CREDITS), $movie);
		$this->loadFullCredits->load($this->getUrl(UrlBuilder::URL_FULL_CREDITS), $movie);
		$this->loadGoofs->load($this->getUrl(UrlBuilder::URL_GOOFS), $movie);
		$this->loadKeywords->load($this->getUrl(UrlBuilder::URL_KEYWORDS), $movie);
		$this->loadLocations->load($this->getUrl(UrlBuilder::URL_LOCATIONS), $movie);
		$this->loadMedia->loadMedia($this->getUrl(UrlBuilder::URL_MEDIA_INDEX), $movie);
		$this->loadPlotSummary->load($this->getUrl(UrlBuilder::URL_PLOT_SUMMARY), $movie);
		$this->loadQuotes->load($this->getUrl(UrlBuilder::URL_QUOTES), $movie);
		$this->loadRatings->load($this->getUrl(UrlBuilder::URL_RATINGS), $movie);
		$this->loadReleaseInfo->load($this->getUrl(UrlBuilder::URL_RELEASE_INFO), $movie);
		$this->loadReviews->load($this->getUrl(UrlBuilder::URL_REVIEWS), $movie);
		$this->loadSoundtrack->load($this->getUrl(UrlBuilder::URL_SOUNDTRACK), $movie);
		$this->loadSynopsis->load($this->getUrl(UrlBuilder::URL_SYNOPSIS), $movie);
		$this->loadTagLines->load($this->getUrl(UrlBuilder::URL_TAG_LINE), $movie);
		$this->loadTechnical->load($this->getUrl(UrlBuilder::URL_TECHNICAL), $movie);
		$this->loadTrivia->load($this->getUrl(UrlBuilder::URL_TRIVIA), $movie);
		$this->loadVideoGallery->load($this->getUrl(UrlBuilder::URL_VIDEO_GALLERY), $movie);

		return $movie;
	}


	public function setUpUrl(string $input)
	{
		$this->url = $this->urlBuilder->buildUrl($input);
	}


	public function getUrl(string $append = '') : string
	{
		return $this->url . $append;
	}


	/**
	 * @param string $url
	 */
	public function setUrl(string $url)
	{
		$this->url = $url;
	}
}
