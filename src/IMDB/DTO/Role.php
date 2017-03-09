<?php

namespace MovieParser\IMDB\DTO;


class Role extends Dto
{
	/** @var Person */
	private $person;
	/** @var Character */
	private $character;
	/** @var Character */
	private $alias;
	/** @var string */
	private $name;
	/** @var string */
	private $description;
	/** @var string */
	private $type;

	/**
	 * @return Person
	 */
	public function getPerson()
	{
		return $this->person;
	}


	/**
	 * @param Person $person
	 */
	public function setPerson($person)
	{
		$this->person = $person;
	}


	/**
	 * @return Character
	 */
	public function getCharacter()
	{
		return $this->character;
	}


	/**
	 * @param Character $character
	 */
	public function setCharacter($character)
	{
		$this->character = $character;
	}


	/**
	 * @return Character
	 */
	public function getAlias()
	{
		return $this->alias;
	}


	/**
	 * @param Character $alias
	 */
	public function setAlias($alias)
	{
		$this->alias = $alias;
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


	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}


	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}


	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
}