<?php

namespace MovieParser\IMDB;

use Psr;
use Atrox;


class Matcher
{

	const TYPE_MOVIE = 1;
	const TYPE_SERIES = 2;

	/** @var UrlBuilder */
	private $urlBuilder;


	public function __construct(
		UrlBuilder $urlBuilder
	) {
		$this->urlBuilder = $urlBuilder;
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function process($response)
	{
		$processedData = [];

		$type = $this->getType($response);
		switch ($type) {
			case self::TYPE_MOVIE:
				$processedData = $this->processMovie($response);
				break;
		}
		$processedData['type'] = $type;

		return $processedData;
	}


	/**
	 * @param string $response
	 * @return int self::TYPE_*
	 */
	public function getType($response)
	{
		return self::TYPE_MOVIE;
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processMovie($response)
	{
		$match = Atrox\Matcher::multi([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'title' => Atrox\Matcher::single('//h1/text()'),
			'year' => Atrox\Matcher::single('//span[@id="titleYear"]/a/text()'),
			'rating' => Atrox\Matcher::single('//span[@itemprop="ratingValue"]/text()'),
			'ratingCount' => Atrox\Matcher::single('//span[@itemprop="ratingCount"]/text()'),
			'poster' => Atrox\Matcher::single('//img[@itemprop="image"]/@src'),
			'description' => Atrox\Matcher::single('//div[@itemprop="description"]/text()'),
			'genres' => Atrox\Matcher::multi('//div[@itemprop="genre"]/a/text()'),
			'links' => Atrox\Matcher::multi('//div[@class="quicklinkSectionItem"]/a[@class="quicklink"]/@href'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processFullCredits($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'cast' => Atrox\Matcher::multi('//table[@class="cast_list"]/tr', [
				'person' => Atrox\Matcher::single('./td[1]/a/@href'),
				'person_name' => Atrox\Matcher::single('.//span[@itemprop="name"]'),
				'character' => Atrox\Matcher::single('./td[@class="character"]/div/a[1]/@href'),
				'character_name' => Atrox\Matcher::single('./td[@class="character"]/div/a[1]'),
				'alias' => Atrox\Matcher::single('./td[@class="character"]/div/a[2]/@href'),
				'alias_name' => Atrox\Matcher::single('./td[@class="character"]/div/a[2]'),
				'description' => Atrox\Matcher::single('./td[@class="character"]/div/text()[last()]'),
			]),
			'crew' => Atrox\Matcher::multi('//h4[@class="dataHeaderWithBorder"]', [
				'role_name' => Atrox\Matcher::single('./text()'),
				'people' => Atrox\Matcher::multi('following-sibling::table[@class="simpleTable simpleCreditsTable"][1]/tbody/tr', [
					'person' => Atrox\Matcher::single('./td[1]/a/@href'),
					'person_name' => Atrox\Matcher::single('./td[1]/a/text()'),
					'description' => Atrox\Matcher::single('./td[3]/text()'),
				]),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processReleaseInfo($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'release' => Atrox\Matcher::multi('//table[@id="release_dates"]/tr', [
				'country' => Atrox\Matcher::single('td[1]/a/text()'),
				'date' => Atrox\Matcher::single('td[2]/text()'),
				'year' => Atrox\Matcher::single('td[2]/a/text()'),
				'note' => Atrox\Matcher::single('td[3]/text()'),
			]),
			'alias' => Atrox\Matcher::multi('//table[@id="akas"]/tr', [
				'country' => Atrox\Matcher::single('td[1]/text()'),
				'name' => Atrox\Matcher::single('td[2]/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processCompanyCredits($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'credits' => Atrox\Matcher::multi('//h4[@class="dataHeaderWithBorder"]', [
				'name' => Atrox\Matcher::single('text()'),
				'companies' => Atrox\Matcher::multi('following-sibling::ul[1]/li', [
					'companyName' => Atrox\Matcher::single('a/text()'),
					'companyLink' => Atrox\Matcher::single('a/@href'),
					'companyNote' => Atrox\Matcher::single('text()[last()]'),
				]),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processLocations($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'locations' => Atrox\Matcher::multi('//div[contains(@class, "soda sodavote")]/dt/a/text()')
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processTechnical($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'runtime' => Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Runtime")]/following-sibling::td/text()'),
			'color' => Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Color")]/following-sibling::td/a/text()'),
			'ratio' => Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Aspect Ratio")]/following-sibling::td/text()'),
			'camera' => Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Camera")]/following-sibling::td/text()'),
			'laboratory' => Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Laboratory")]/following-sibling::td/text()'),
			'filmLength' => Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Film Length")]/following-sibling::td/text()'),
			'negativeFormat' => Atrox\Matcher::single('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Negative Format")]/following-sibling::td/text()'),
			'cineProcess' => Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Cinematographic Process")]/following-sibling::td/text()'),
			'printed' => Atrox\Matcher::multi('//table[@class="dataTable labelValueTable"]/tbody/tr/td[contains(text(), "Printed Film Format")]/following-sibling::td/text()'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processTagLines($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'tagLines' => Atrox\Matcher::multi('//div[@id="taglines_content"]/div[contains(@class, "soda")]/text()'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processPlotSummary($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'plotSummary' => Atrox\Matcher::multi('//ul[@class="zebraList"]/li/p/text()'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processSynopsis($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'synopsis' => Atrox\Matcher::multi('//div[@id="swiki.2.1"]/text()'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processKeywords($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'keywords' => Atrox\Matcher::multi('//table[@class="dataTable evenWidthTable2Col"]/tbody/tr/td[1]/div/a/text()'),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processTrivia($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'trivia' => Atrox\Matcher::multi('//div[@id="trivia_content"]/div[@class="list"]/div', [
				'id' => Atrox\Matcher::single('@id'),
				'text' => Atrox\Matcher::multi('div[@class="sodatext"]/descendant-or-self::text()'),
				'relevancy' => Atrox\Matcher::single('div[@class="did-you-know-actions"]/a/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processGoofs($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'goofs' => Atrox\Matcher::multi('//div[@id="goofs_content"]/div[@class="list"]/div', [
				'id' => Atrox\Matcher::single('@id'),
				'text' => Atrox\Matcher::multi('div[@class="sodatext"]/descendant-or-self::text()'),
				'relevancy' => Atrox\Matcher::single('div[@class="did-you-know-actions"]/a/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processCrazyCredits($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'credits' => Atrox\Matcher::multi('//div[@id="crazycredits_content"]/div[@class="list"]/div', [
				'id' => Atrox\Matcher::single('@id'),
				'text' => Atrox\Matcher::multi('div[@class="sodatext"]/descendant-or-self::text()'),
				'relevancy' => Atrox\Matcher::single('div[@class="did-you-know-actions"]/a/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param string $response
	 * @return array
	 */
	public function processQuotes($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'quotes' => Atrox\Matcher::multi('//div[@id="quotes_content"]/div[@class="list"]/div', [
				'id' => Atrox\Matcher::single('@id'),
				'text' => Atrox\Matcher::multi('div[@class="sodatext"]/p/descendant-or-self::text()'),
				'relevancy' => Atrox\Matcher::single('div[@class="did-you-know-actions"]/a/text()'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param $response
	 * @return array
	 */
	public function processConnections($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
			'connections' => Atrox\Matcher::multi('//div[@id="connections_content"]/div[@class="list"]/div', [
				'id' => Atrox\Matcher::single('a/@href'),
				'group' => Atrox\Matcher::single('preceding-sibling::h4[1]/text()'),
				'note' => Atrox\Matcher::single('descendant-or-self::text()[position() > 2]'),
			]),
		])
			->fromHtml();

		return $match($response);
	}


	/**
	 * @param $response
	 * @return array
	 */
	public function processImages($response)
	{
		$match = Atrox\Matcher::single([
			'id' => Atrox\Matcher::single('//meta[@property="pageId"]/@content'),
		])
			->fromHtml();

		return $match($response);
	}
}