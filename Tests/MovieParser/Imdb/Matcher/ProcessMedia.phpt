<?php

namespace Tests\MovieParser\IMDB\Parser;

include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessMedia.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessMedia extends \Tester\TestCase
{

	public function testProcessMedia()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessMedia();

		$html = file_get_contents(__DIR__ . '/AntMan-media.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::count(48, $data['media']);
		\Tester\Assert::count(5, $data['mediaTypes']);
		\Tester\Assert::same('/title/tt0478970/mediaindex?refine=production_art&ref_=ttmi_ref_art', $data['mediaTypes'][4]);
		\Tester\Assert::count(5, $data['pages']);
	}


	public function testProcessEpisodeMedia()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessMedia();

		$html = file_get_contents(__DIR__ . '/StarGate-Episode-media.html');

		$data = $matcher->process($html);

		\Tester\Assert::same($data['id'], 'tt0912284');
		\Tester\Assert::count(17, $data['media']);
		\Tester\Assert::count(0, $data['mediaTypes']);
		\Tester\Assert::count(0, $data['pages']);
	}

}


(new ProcessMedia())->run();
