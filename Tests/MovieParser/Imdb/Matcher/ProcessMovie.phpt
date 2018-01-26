<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';


class ProcessMovie extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessMovie(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/antman.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::same($data['year'], '2015');
		\Tester\Assert::same($data['rating'], '7,3');
		\Tester\Assert::same($data['poster'], 'https://images-na.ssl-images-amazon.com/images/M/MV5BMjM2NTQ5Mzc2M15BMl5BanBnXkFtZTgwNTcxMDI2NTE@._V1_UX182_CR0,0,182,268_AL_.jpg');
		\Tester\Assert::count(4, $data['genres']);
		\Tester\Assert::count(27, $data['links']);
		\Tester\Assert::same('/title/tt0478970/companycredits?ref_=tt_ql_dt_4', $data['links'][3]);
	}
}


(new ProcessMovie())->run();
