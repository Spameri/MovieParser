<?php

namespace MovieParser\IMDB\DTO;

class Release
{
	/** @var string */
	private $country;
	/** @var string */
	private $date;
	/** @var string */
	private $note;


	public function __construct($data)
	{
		if (isset($data['country'])) $this->setCountry($data['country']);
		if (isset($data['date'])) $this->setDate($data['date'] . $data['year']);
		if (isset($data['note'])) $this->setNote($data['note']);
	}


	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * @param string $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
	}


	/**
	 * @return string
	 */
	public function getDate()
	{
		return $this->date;
	}


	/**
	 * @param string $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
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