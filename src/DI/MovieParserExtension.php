<?php

namespace MovieParser\DI;


class MovieParserExtension extends \Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$builder = $this->getContainerBuilder();

		$this->compiler->parseServices($builder, $this->loadFromFile(__DIR__ . '/config.neon'), $this->name);
	}


	public static function register(\Nette\Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, \Nette\DI\Compiler $compiler) {
			$compiler->addExtension('movieParser', new MovieParserExtension());
		};
	}
}