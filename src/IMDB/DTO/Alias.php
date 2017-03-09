<?php

namespace MovieParser\IMDB\DTO;

class Alias extends Dto
{
	/** @var string */
	private $country;
	/** @var string */
	private $name;


	public function __construct($data)
	{
		if (isset($data['country'])) $this->setCountry($data['country']);
		if (isset($data['name'])) $this->setName($data['name']);
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
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
}