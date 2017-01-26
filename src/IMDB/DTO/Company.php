<?php

namespace MovieParser\IMDB\DTO;


class Company
{
	/** @var string */
	private $id;
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
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @param string $id
	 */
	public function setId($id)
	{
		$this->id = $id;
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