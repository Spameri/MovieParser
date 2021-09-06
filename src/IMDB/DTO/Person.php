<?php

namespace MovieParser\IMDB\DTO;

class Person extends Dto
{
	/** @var string */
	private $name;


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
