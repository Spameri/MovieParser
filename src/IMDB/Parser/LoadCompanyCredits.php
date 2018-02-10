<?php

namespace MovieParser\IMDB\Parser;


class LoadCompanyCredits
{

	/**
	 * @var \MovieParser\IMDB\UrlBuilder
	 */
	private $urlBuilder;

	/**
	 * @var \MovieParser\IMDB\Matcher\ProcessCompanyCredits
	 */
	private $processCompanyCredits;


	public function __construct(
		\MovieParser\IMDB\UrlBuilder $urlBuilder
		, \MovieParser\IMDB\Matcher\ProcessCompanyCredits $processCompanyCredits
	)
	{
		$this->processCompanyCredits = $processCompanyCredits;
		$this->client = new \GuzzleHttp\Client();
		$this->urlBuilder = $urlBuilder;
	}


	public function load(string $link, \MovieParser\IMDB\DTO\Movie $movie) : \MovieParser\IMDB\DTO\Movie
	{
		if (strpos($link, \MovieParser\IMDB\UrlBuilder::URL_COMPANY_CREDITS)) {
			$content = $this->client->get($link);
			if ($content->getStatusCode() === \MovieParser\IMDB\Parser::STATUS_OK) {
				$data = $this->processCompanyCredits->process($content->getBody()->getContents());
				foreach ($data['credits'] as $creditData) {
					foreach ($creditData['companies'] as $companyData) {
						$company = new \MovieParser\IMDB\DTO\Company([]);
						$company->setName($companyData['companyName']);
						$company->setNote($companyData['companyNote']);
						$company->setId('co' . $this->urlBuilder->getId($companyData['companyLink']));
						$credit = new \MovieParser\IMDB\DTO\Credit();
						$credit->setCompany($company);
						$credit->setGroup($companyData['companyNote']);
						$movie->addCredit($credit);
					}
				}
			}
		}

		return $movie;
	}
}