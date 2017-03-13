<?php

namespace Tests\MovieParser\IMDB\Parser;


include __DIR__ . '/../../../Bootstrap.php';
include __DIR__ . '/../../../../src/IMDB/Parser.php';
include __DIR__ . '/../../../../src/IMDB/UrlBuilder.php';

include __DIR__ . '/../../../../src/IMDB/DTO/Dto.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Alias.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Character.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Company.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Connection.php';
include __DIR__ . '/../../../../src/IMDB/DTO/CrazyCredit.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Credit.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Episode.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Goof.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Image.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Movie.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Person.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Quote.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Release.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Role.php';
include __DIR__ . '/../../../../src/IMDB/DTO/Trivia.php';

include __DIR__ . '/../../../../src/IMDB/Parser/LoadAlternativeVersions.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadAwards.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadBusiness.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadCompanyCredits.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadConnections.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadCrazyCredits.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadFullCredits.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadGoofs.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadKeywords.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadLocations.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadMedia.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadMovie.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadPlotSummary.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadQuotes.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadRatings.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadReleaseInfo.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadReviews.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadSoundtrack.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadSynopsis.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadTagLines.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadTechnical.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadTrivia.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadVideo.php';
include __DIR__ . '/../../../../src/IMDB/Parser/LoadVideoGallery.php';

include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessAlternativeVersions.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessAwards.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessBusiness.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessCompanyCredits.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessConnections.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessCrazyCredits.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessFullCredits.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessGoofs.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessImage.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessKeywords.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessLocations.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessMedia.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessMovie.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessPlotSummary.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessQuotes.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessReleaseInfo.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessSynopsis.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessTagLines.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessTechnical.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessTrivia.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessVideo.php';
include __DIR__ . '/../../../../src/IMDB/Matcher/ProcessVideoGallery.php';


class Get extends \Tester\TestCase
{

	public function testSuccessFullGet()
	{
		$parser = new \MovieParser\IMDB\Parser(
			new \MovieParser\IMDB\UrlBuilder(),
			new \MovieParser\IMDB\Parser\LoadMovie(new \MovieParser\IMDB\Matcher\ProcessMovie()),
			new \MovieParser\IMDB\Parser\LoadAlternativeVersions(new \MovieParser\IMDB\Matcher\ProcessAlternativeVersions()),
			new \MovieParser\IMDB\Parser\LoadAwards(new \MovieParser\IMDB\Matcher\ProcessAwards()),
			new \MovieParser\IMDB\Parser\LoadBusiness(),
			new \MovieParser\IMDB\Parser\LoadCompanyCredits(new \MovieParser\IMDB\UrlBuilder(), new \MovieParser\IMDB\Matcher\ProcessCompanyCredits()),
			new \MovieParser\IMDB\Parser\LoadConnections(new \MovieParser\IMDB\Matcher\ProcessConnections()),
			new \MovieParser\IMDB\Parser\LoadCrazyCredits(new \MovieParser\IMDB\Matcher\ProcessCrazyCredits()),
			new \MovieParser\IMDB\Parser\LoadFullCredits(new \MovieParser\IMDB\UrlBuilder(), new \MovieParser\IMDB\Matcher\ProcessFullCredits()),
			new \MovieParser\IMDB\Parser\LoadGoofs(new \MovieParser\IMDB\Matcher\ProcessGoofs()),
			new \MovieParser\IMDB\Parser\LoadKeywords(new \MovieParser\IMDB\Matcher\ProcessKeywords()),
			new \MovieParser\IMDB\Parser\LoadLocations(new \MovieParser\IMDB\Matcher\ProcessLocations()),
			new \MovieParser\IMDB\Parser\LoadMedia(new \MovieParser\IMDB\UrlBuilder(), new \MovieParser\IMDB\Matcher\ProcessMedia(), new \MovieParser\IMDB\Matcher\ProcessImage()),
			new \MovieParser\IMDB\Parser\LoadPlotSummary(new \MovieParser\IMDB\Matcher\ProcessPlotSummary()),
			new \MovieParser\IMDB\Parser\LoadQuotes(new \MovieParser\IMDB\Matcher\ProcessQuotes()),
			new \MovieParser\IMDB\Parser\LoadRatings(),
			new \MovieParser\IMDB\Parser\LoadReleaseInfo(new \MovieParser\IMDB\Matcher\ProcessReleaseInfo()),
			new \MovieParser\IMDB\Parser\LoadReviews(),
			new \MovieParser\IMDB\Parser\LoadSoundtrack(),
			new \MovieParser\IMDB\Parser\LoadSynopsis(new \MovieParser\IMDB\Matcher\ProcessSynopsis()),
			new \MovieParser\IMDB\Parser\LoadTagLines(new \MovieParser\IMDB\Matcher\ProcessTagLines()),
			new \MovieParser\IMDB\Parser\LoadTechnical(new \MovieParser\IMDB\Matcher\ProcessTechnical()),
			new \MovieParser\IMDB\Parser\LoadTrivia(new \MovieParser\IMDB\Matcher\ProcessTrivia()),
			new \MovieParser\IMDB\Parser\LoadVideoGallery(new \MovieParser\IMDB\Matcher\ProcessVideoGallery(), new \MovieParser\IMDB\UrlBuilder(), new \MovieParser\IMDB\Parser\LoadVideo(new \MovieParser\IMDB\Matcher\ProcessVideo()))
		);

		$entity = $parser->get('http://www.imdb.com/title/tt0478970/');

		\Tester\Assert::type(\MovieParser\IMDB\DTO\Movie::class, $entity);
	}
}
(new Get())->run();
