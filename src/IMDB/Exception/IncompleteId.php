<?php

namespace MovieParser\IMDB\Exception;

use MovieParser;


class IncompleteId extends MovieParser\Exception\Exception
{

	protected $message = 'Input is missing type, should contain something like tt0000001';
}