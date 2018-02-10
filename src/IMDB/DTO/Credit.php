<?php

namespace MovieParser\IMDB\DTO;


class Credit extends Dto
{
	/** @var Company */
	private $company;
	/** @var string */
	private $group;


	/**
	 * @return Company
	 */
	public function getCompany()
	{
		return $this->company;
	}


	/**
	 * @param Company $company
	 */
	public function setCompany($company)
	{
		$this->company = $company;
	}


	/**
	 * @return string
	 */
	public function getGroup()
	{
		return $this->group;
	}


	/**
	 * @param string $group
	 */
	public function setGroup($group)
	{
		$this->group = $group;
	}
}
