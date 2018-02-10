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

	public function testProcessImage()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessImage();

		$html = file_get_contents(__DIR__ . '/AntMan-image.html');

		$data = $matcher->process($html);

		$imageData = $data['imageData'];
		$jsonDecode =  \Nette\Utils\Json::decode($imageData);

		\Tester\Assert::same($data['id'], 'tt0478970');
		\Tester\Assert::type('object', $jsonDecode);
		\Tester\Assert::count(260, $jsonDecode->mediaviewer->galleries->{$data['id']}->allImages);
	}
}

(new ProcessImage())->run();
