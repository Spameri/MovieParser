<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessImage.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Image.php';


class ProcessImage extends \Tester\TestCase
{

	public function testProcessMovie()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessImage(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-image.html');

		$data = $matcher->process($html);

		$jsonDecode = json_decode($data['imageData']);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::type('object', $jsonDecode);
		\Tester\Assert::count(242, $jsonDecode->mediaViewerModel->allImages);
	}
}


(new ProcessImage())->run();
