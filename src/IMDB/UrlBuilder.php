<?php

namespace MovieParser\IMDB;

use MovieParser;


class UrlBuilder
{

	public const URL_IMDB = 'http://www.imdb.com/';
	public const URL_IMDB_NO_BACKLASH = 'http://www.imdb.com';
	public const URL_TYPE_TITLE = 'title';
	public const URL_TYPE_VIDEO = 'video/imdb';
	public const URL_TYPE_PERSON = 'name';
	public const URL_TYPE_CHARACTER = 'character';

	public const TYPE_TITLE = 'tt';
	public const TYPE_PERSON = 'nm';
	public const TYPE_CHARACTER = 'ch';
	public const TYPE_VIDEO = 'vi';


	public const URL_FULL_CREDITS = 'fullcredits';
	public const URL_RELEASE_INFO = 'releaseinfo';
	public const URL_EXTERNAL_SITES = 'externalsites';
	public const URL_BUSINESS = 'business';
	public const URL_COMPANY_CREDITS = 'companycredits';
	public const URL_LOCATIONS = 'locations';
	public const URL_TECHNICAL = 'technical';
	public const URL_LITERATURE = 'literature';

	public const URL_TAG_LINE = 'taglines';
	public const URL_PLOT_SUMMARY = 'plotsummary';
	public const URL_SYNOPSIS = 'synopsis';
	public const URL_KEYWORDS = 'keywords';
	public const URL_PARENTAL = 'parentalguide';

	public const URL_TRIVIA = 'trivia';
	public const URL_GOOFS = 'goofs';
	public const URL_CRAZY_CREDITS = 'crazycredits';
	public const URL_QUOTES = 'quotes';
	public const URL_ALTERNATE = 'alternateversions';
	public const URL_MOVIE_CONNECTIONS = 'movieconnections';
	public const URL_SOUNDTRACK = 'soundtrack';

	public const URL_MEDIA_INDEX = 'mediaindex';
	public const URL_MEDIA_VIEWER = 'mediaviewer';
	public const URL_VIDEO_GALLERY = 'videogallery';
	public const URL_VIDEO = 'video';

	public const URL_AWARDS = 'awards';
	public const URL_FAQ = 'faq';
	public const URL_REVIEWS = 'reviews';
	public const URL_RATINGS = 'ratings';
	public const URL_EXTERNAL_REVIEWS = 'externalreviews';

	public const URL_TV_SCHEDULE = 'tvschedule';

	public const IMDB_URLS = [
		self::URL_FULL_CREDITS,
		self::URL_RELEASE_INFO,
		self::URL_EXTERNAL_SITES,
		self::URL_BUSINESS,
		self::URL_COMPANY_CREDITS,
		self::URL_LOCATIONS,
		self::URL_TECHNICAL,
		self::URL_LITERATURE,
		self::URL_TAG_LINE,
		self::URL_PLOT_SUMMARY,
		self::URL_SYNOPSIS,
		self::URL_KEYWORDS,
		self::URL_PARENTAL,
		self::URL_TRIVIA,
		self::URL_GOOFS,
		self::URL_CRAZY_CREDITS,
		self::URL_QUOTES,
		self::URL_ALTERNATE,
		self::URL_MOVIE_CONNECTIONS,
		self::URL_SOUNDTRACK,
		self::URL_MEDIA_INDEX,
		self::URL_VIDEO_GALLERY,
		self::URL_AWARDS,
		self::URL_FAQ,
		self::URL_REVIEWS,
		self::URL_RATINGS,
		self::URL_EXTERNAL_REVIEWS,
		self::URL_TV_SCHEDULE,
		self::URL_VIDEO,
	];


	/**
	 * @param string $input
	 * @return string
	 * @throws \MovieParser\IMDB\Exception\IncompleteId
	 */
	public function buildUrl($input)
	{
		$url = self::URL_IMDB;
		$type = $this->getType($input);
		$id = $this->getId($input);

		if ($type === self::TYPE_PERSON) {
			$url .= self::URL_TYPE_PERSON . '/';

		} elseif ($type === self::TYPE_CHARACTER) {
			$url .= self::URL_TYPE_CHARACTER . '/';

		} elseif ($type === self::TYPE_VIDEO) {
			$url .= self::URL_TYPE_VIDEO . '/';

		} else {
			$url .= self::URL_TYPE_TITLE . '/';
		}

		$url .= $type . $id . '/';

		return $url;
	}


	/**
	 * @param string $input
	 * @return string
	 */
	public function getType($input)
	{
		if (strpos($input, self::TYPE_TITLE)) {
			$type = self::TYPE_TITLE;

		} elseif (strpos($input, self::TYPE_PERSON)) {
			$type = self::TYPE_PERSON;

		} elseif (strpos($input, self::TYPE_CHARACTER)) {
			$type = self::TYPE_CHARACTER;

		} elseif (strpos($input, self::TYPE_VIDEO)) {
			$type = self::TYPE_VIDEO;

		} else {
			$type = self::TYPE_TITLE;
		}

		return $type;
	}


	/**
	 * @param string $input
	 * @return int
	 * @throws MovieParser\IMDB\Exception\IncompleteId
	 */
	public function getId($input)
	{
		preg_match('/\d+/', $input, $output);

		if ( ! isset($output[0])) {
			throw new MovieParser\IMDB\Exception\IncompleteId;
		}

		return $output[0];
	}
}
