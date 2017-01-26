<?php

namespace MovieParser\IMDB\DTO;


class Connection
{
	/** @var string */
	private $connection;
	/** @var string */
	private $note;
	/** @var string */
	private $type;


	/**
	 * @return string
	 */
	public function getConnection()
	{
		return $this->connection;
	}


	/**
	 * @param string $connection
	 */
	public function setConnection($connection)
	{
		$this->connection = $connection;
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