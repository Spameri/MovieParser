<?php
namespace MovieParser\IMDB\Parser;


class LoadConnections
{

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessConnections
	 */
	private $processConnections;


	public function __construct(
		\MovieParser\IMDB\Matcher\ProcessConnections $processConnections
	)
	{
		$this->processConnections = $processConnections;
		$this->client = new \GuzzleHttp\Client();
	}


	public function load(
		string $link,
		\MovieParser\IMDB\DTO\Movie $movie
	) : \MovieParser\IMDB\DTO\Movie
	{
		if (\strpos($link, \MovieParser\IMDB\UrlBuilder::URL_MOVIE_CONNECTIONS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processConnections->process($content->getBody()->getContents());
				if ( ! $movie->getId()) {
					$movie->setId(\str_replace('tt', '', $data['id']));
				}

				$connectionData = [];
				foreach ($data['connections'] as $value) {
					$connection = new \MovieParser\IMDB\DTO\Connection();
					$connection->setConnection($value['id']);
					$connection->setType(\rtrim($value['group'], ' '));
					$note = $value['note'];
					if (\is_array($value['note'])) {
						$note = \implode(' ', $value['note']);
					}
					$connection->setNote($note);
					$connectionData[] = $connection;
				}
				$movie->setConnections($connectionData);
			}
		}

		return $movie;
	}
}
