<?php

namespace MovieParser\IMDB\Parser;


class LoadVideo
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessVideo
	 */
	private $processVideo;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessVideo $processVideo
	)
	{
		$this->processVideo = $processVideo;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(string $link) : array
	{
		$data = [];
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_VIDEO)) {
			$content = $this->client->get($link);
			$data = $this->processVideo->process($content->getBody()->getContents());
			$data['videoObject'] = \Nette\Utils\Json::decode($data['videoObject']);
		}

		return $data;
	}
}
