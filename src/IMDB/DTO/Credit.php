<?php

namespace MovieParser\IMDB\DTO;

class Credit extends Dto
{
	/** @var Company */
	private $company;
	/** @var string */
	private $note;


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
	public function getNote()
	{
		return $this->note;
	}


	/**
	 * @param string $note
	 */
	public function setNote($note)
	{
		$this->note = $note;
	}
}
