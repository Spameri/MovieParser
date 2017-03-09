<?php

namespace MovieParser\IMDB\DTO;


class Company extends Dto
{
	/** @var string */
	private $name;


	public function __construct($data)
	{
		if (isset($data['id'])) $this->setId($data['id']);
		if (isset($data['name'])) $this->setName($data['name']);
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