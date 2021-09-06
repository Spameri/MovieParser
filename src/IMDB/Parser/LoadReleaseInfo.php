<?php

namespace MovieParser\IMDB\Parser;


class LoadReleaseInfo
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessReleaseInfo
	 */
	private $processReleaseInfo;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessReleaseInfo $processReleaseInfo
	)
	{
		$this->processReleaseInfo = $processReleaseInfo;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_RELEASE_INFO)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processReleaseInfo->process($content->getBody()->getContents());
				\Tracy\Debugger::barDump($data);
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				foreach ($data['release'] as $releaseData) {
					$release = new \MovieParser\IMDB\DTO\Release($releaseData);
					$movie->addRelease($release);
				}
				foreach ($data['alias'] as $aliasData) {
					$alias = new \MovieParser\IMDB\DTO\Alias($aliasData);
					$movie->addAlias($alias);
				}
			}
		}

		return $movie;
	}
}
