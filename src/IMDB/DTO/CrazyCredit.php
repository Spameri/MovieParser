<?php

namespace MovieParser\IMDB\DTO;

class CrazyCredit extends Dto
{
	/** @var string */
	private $video;
	/** @var string */
	private $text;
	/** @var int */
	private $relevancy;


	/**
	 * @return int
	 */
	public function getRelevancy()
	{
		return $this->relevancy;
	}


	/**
	 * @param int $relevancy
	 */
	public function setRelevancy($relevancy)
	{
		$this->relevancy = $relevancy;
	}


	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}


	/**
	 * @param string $text
	 */
	public function setText($text)
	{
		$this->text = $text;
	}


	/**
	 * @return string
	 */
	public function getVideo()
	{
		return $this->video;
	}


	/**
	 * @param string $video
	 */
	public function setVideo($video)
	{
		$this->video = $video;
	}
}
