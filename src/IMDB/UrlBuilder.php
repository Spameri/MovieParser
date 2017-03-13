<?php

namespace MovieParser\IMDB;

use MovieParser;


class UrlBuilder
{

	const URL_IMDB = 'http://www.imdb.com/';
	const URL_TYPE_TITLE = 'title';
	const URL_TYPE_VIDEO = 'video/imdb';
	const URL_TYPE_PERSON = 'name';
	const URL_TYPE_CHARACTER = 'character';

	const TYPE_TITLE = 'tt';
	const TYPE_PERSON = 'nm';
	const TYPE_CHARACTER = 'ch';
	const TYPE_VIDEO = 'vi';


	const URL_FULL_CREDITS = 'fullcredits';
	const URL_RELEASE_INFO = 'releaseinfo';
	const URL_EXTERNAL_SITES = 'externalsites';
	const URL_BUSINESS = 'business';
	const URL_COMPANY_CREDITS = 'companycredits';
	const URL_LOCATIONS = 'locations';
	const URL_TECHNICAL = 'technical';
	const URL_LITERATURE = 'literature';

	const URL_TAG_LINE = 'taglines';
	const URL_PLOT_SUMMARY = 'plotsummary';
	const URL_SYNOPSIS = 'synopsis';
	const URL_KEYWORDS = 'keywords';
	const URL_PARENTAL = 'parentalguide';

	const URL_TRIVIA = 'trivia';
	const URL_GOOFS = 'goofs';
	const URL_CRAZY_CREDITS = 'crazycredits';
	const URL_QUOTES = 'quotes';
	const URL_ALTERNATE = 'alternateversions';
	const URL_MOVIE_CONNECTIONS = 'movieconnections';
	const URL_SOUNDTRACK = 'soundtrack';

	const URL_MEDIA_INDEX = 'mediaindex';
	const URL_MEDIA_VIEWER = 'mediaviewer';
	const URL_VIDEO_GALLERY = 'videogallery';
	const URL_VIDEO = 'video';

	const URL_AWARDS = 'awards';
	const URL_FAQ = 'faq';
	const URL_REVIEWS = 'reviews';
	const URL_RATINGS = 'ratings';
	const URL_EXTERNAL_REVIEWS = 'externalreviews';

	const URL_TV_SCHEDULE = 'tvschedule';

	const IMDB_URLS = [
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