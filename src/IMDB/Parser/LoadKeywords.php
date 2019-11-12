<?php
namespace MovieParser\IMDB\Parser;


class LoadKeywords
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessKeywords
	 */
	private $processKeywords;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessKeywords $processKeywords
	)
	{
		$this->processKeywords = $processKeywords;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_KEYWORDS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processKeywords->process($content->getBody()->getContents());
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}
				$movie->setKeyWords($data['keywords']);
			}
		}

		return $movie;
	}
}