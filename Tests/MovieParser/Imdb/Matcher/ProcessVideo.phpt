<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessVideo.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';


class ProcessVideo extends \Tester\TestCase
{

	public function testProcessVideo()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessVideo(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-video.html');

		$data = $matcher->process($html);

		\Tester\Assert::same('http://www.imdb.com/video/imdb/vi3109793817/imdb/single?vPage=1', $data['videoObject']);
		\Tester\Assert::count(5, $data['description']);
	}


	public function testProcessObject()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessVideo(new \MovieParser\IMDB\UrlBuilder());

		$html = file_get_contents(__DIR__ . '/AntMan-videoObject.html');

		$data = $matcher->processObject($html);

		\Tester\Assert::same('http://video-http.media-imdb.com/MV5BZjk0YzI1YTYtMzEyMS00ZWEwLTkyZGUtYTExZmY0ZDNhNjcwXkExMV5BbXA0XkFpbWRiLWV0cy10cmFuc2NvZGU@.mp4?Expires=1489267144&Signature=QGuPXCAmfBQPOpHFkHuz2ZrYacKl5PS8pEpcsgoNbqFJAVajI3TZBqJ5Ystorisdinbb3indLC5JuhaS7W096jgRM2sYPJdwkB8dLZsaXUXb2vj2rqc20mfM-CrDYAM9EMTvB2yF5iz2NpvYAG2JJhLvVtslUHApG8dSuCX7mtw_&Key-Pair-Id=APKAILW5I44IHKUN2DYA',
			json_decode($data['videoObject'])->videoPlayerObject->video->videoInfoList[1]->videoUrl);
	}
}


(new ProcessVideo())->run();
