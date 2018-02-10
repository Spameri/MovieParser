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
		$matcher = new \MovieParser\IMDB\Matcher\ProcessVideo();

		$html = file_get_contents(__DIR__ . '/AntMan-video.html');

		$data = $matcher->process($html);

		\Nette\Utils\Json::decode($data['videoObject']);
		$videoObject = \Nette\Utils\Json::decode($data['videoObject']);

		\Tester\Assert::same(
			'https://video-http.media-imdb.com/MV5BMTkzZTQwMTAtYTU1ZC00M2Q2LTgxODMtNDVmNWM4NDhlZGZkXkExMV5BbXA0XkFpbWRiLWV0cy10cmFuc2NvZGU@.mp4?Expires=1517602746&Signature=hgliOhy5PIka3ESQLTHp5bS8ntz3UAkdyZEgEm0CVLio3oMLVZVTYEcaVe3JBYjz0JrfmtWB9Dw~tnJYvDOFzHHrra0bfeZK804nrFzg~UmBfNTBIgfMj3Q-iDSGg0qrgsioKGASRJnrg5lSK4UO~mBOCEPDieHw3fef9kRwYa4_&Key-Pair-Id=APKAILW5I44IHKUN2DYA',
			$videoObject->videos->videoMetadata->vi3109793817->encodings[0]->videoUrl
		);
		\Tester\Assert::same(
			'Armed with a super-suit with the astonishing ability to shrink in scale but increase in strength, con-man Scott Lang must embrace his inner hero and help his mentor, Dr. Hank Pym, plan and pull off a heist that will save the world.',
			$videoObject->videos->videoMetadata->vi3109793817->description
		);
	}


	public function testProcessObject()
	{
		$matcher = new \MovieParser\IMDB\Matcher\ProcessVideo();

		$html = file_get_contents(__DIR__ . '/AntMan-videoObject.html');

		$data = $matcher->processObject($html);

		\Tester\Assert::same('http://video-http.media-imdb.com/MV5BZjk0YzI1YTYtMzEyMS00ZWEwLTkyZGUtYTExZmY0ZDNhNjcwXkExMV5BbXA0XkFpbWRiLWV0cy10cmFuc2NvZGU@.mp4?Expires=1489267144&Signature=QGuPXCAmfBQPOpHFkHuz2ZrYacKl5PS8pEpcsgoNbqFJAVajI3TZBqJ5Ystorisdinbb3indLC5JuhaS7W096jgRM2sYPJdwkB8dLZsaXUXb2vj2rqc20mfM-CrDYAM9EMTvB2yF5iz2NpvYAG2JJhLvVtslUHApG8dSuCX7mtw_&Key-Pair-Id=APKAILW5I44IHKUN2DYA',
			json_decode($data['videoObject'])->videoPlayerObject->video->videoInfoList[1]->videoUrl);
	}
}


(new ProcessVideo())->run();
