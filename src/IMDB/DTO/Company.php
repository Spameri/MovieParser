<?php

namespace MovieParser\IMDB\DTO;


class Company extends Dto
{
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string|NULL
	 */
	private $note;


	public function __construct($data)
	{
		if (isset($data['id'])) $this->setId($data['id']);
		if (isset($data['name'])) $this->setName($data['name']);
		if (isset($data['note'])) $this->setNote($data['note']);
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


	public function getNote() : ?string
	{
		return $this->note;
	}


	public function setNote(?string $note)
	{
		$this->note = $note;
	}
}