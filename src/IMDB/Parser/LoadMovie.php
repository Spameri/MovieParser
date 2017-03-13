<?php
namespace MovieParser\IMDB\Parser;


class LoadMovie
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessMovie
	 */
	private $processMovie;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessMovie $processMovie
	)
	{
		$this->processMovie = $processMovie;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link) : \MovieParser\IMDB\DTO\Movie
	{
		$content = $this->client->get($link);
		$data = $this->processMovie->process($content->getBody()->getContents());

		return new \MovieParser\IMDB\DTO\Movie($data);
	}
}
