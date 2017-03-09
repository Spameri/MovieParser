<?php

namespace MovieParser\IMDB\DTO;


class Image extends Dto
{

	/**
	 * @var string
	 */
	private $video;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var integer
	 */
	private $type;

	/**
	 * @var string
	 */
	private $src;

	/**
	 * @var string
	 */
	private $copyright;

	/**
	 * @var string
	 */
	private $author;

	/**
	 * @var array
	 */
	private $characters;

	/**
	 * @var array
	 */
	private $people;


	/**
	 * @return string
	 */
	public function getVideo() : string
	{
		return $this->video;
	}


	/**
	 * @param string $video
	 */
	public function setVideo(string $video)
	{
		$this->video = $video;
	}


	/**
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->title;
	}


	/**
	 * @param string $title
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
	}


	/**
	 * @return int
	 */
	public function getType() : int
	{
		return $this->type;
	}


	/**
	 * @param int $type
	 */
	public function setType(int $type)
	{
		$this->type = $type;
	}


	/**
	 * @return string
	 */
	public function getSrc() : string
	{
		return $this->src;
	}


	/**
	 * @param string $src
	 */
	public function setSrc(string $src)
	{
		$this->src = $src;
	}


	/**
	 * @return string
	 */
	public function getCopyright() : string
	{
		return $this->copyright;
	}


	/**
	 * @param string $copyright
	 */
	public function setCopyright($copyright)
	{
		$this->copyright = $copyright;
	}


	/**
	 * @return string
	 */
	public function getAuthor() : string
	{
		return $this->author;
	}


	/**
	 * @param string $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}


	/**
	 * @return array
	 */
	public function getCharacters() : array
	{
		return $this->characters;
	}


	/**
	 * @param array $characters
	 */
	public function setCharacters(array $characters)
	{
		$this->characters = $characters;
	}


	/**
	 * @return array
	 */
	public function getPeople() : array
	{
		return $this->people;
	}


	/**
	 * @param array $people
	 */
	public function setPeople(array $people)
	{
		$this->people = $people;
	}
}