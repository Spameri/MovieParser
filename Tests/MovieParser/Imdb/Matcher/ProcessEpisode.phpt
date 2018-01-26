<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessMovie.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessEpisode extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessMovie();

		$html = file_get_contents(__DIR__ . '/WalkingDead-episode.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('tt5207756', $data['id']);
		\Tester\Assert::same('Say Yes ', $data['title']);
		\Tester\Assert::same('7,5', $data['rating']);
		\Tester\Assert::same('https://images-na.ssl-images-amazon.com/images/M/MV5BMGRmNmI2OGYtNjk4ZC00N2ZhLTg3OGItM2UxOGUxMDAxNjFiXkEyXkFqcGdeQXVyNzI2MDU5NTg@._V1_UX182_CR0,0,182,268_AL_.jpg', $data['poster']);
		\Tester\Assert::count(3, $data['genres']);
		\Tester\Assert::count(14, $data['links']);
		\Tester\Assert::same('/title/tt5207756/technical?ref_=tt_ql_dt_7', $data['links'][3]);
		\Tester\Assert::same('/title/tt1520211?ref_=tt_ov_inf', $data['show']);
		\Tester\Assert::same('Season 7', $data['season']);
		\Tester\Assert::same('Episode 12', $data['episode']);
	}


	public function testProcessEpisode()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessMovie();

		$html = file_get_contents(__DIR__ . '/stargate-episode.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('tt0756405', $data['id']);
		\Tester\Assert::same('Flesh and Blood ', $data['title']);
		\Tester\Assert::same('8,5', $data['rating']);
	}
}


(new ProcessEpisode())->run();
