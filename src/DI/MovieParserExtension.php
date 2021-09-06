<?php

namespace MovieParser\DI;


class MovieParserExtension extends \Nette\DI\CompilerExtension
{

	public function loadConfiguration()
	{
		parent::loadConfiguration();

		$services = $this->loadFromFile(__DIR__ . '/config.neon');

		$aliasedServices = [];
		foreach ($services['services'] as $key => $service) {
			$aliasedServices['movieParser.' . $key] = $service;
		}

		$this->compiler->loadDefinitionsFromConfig(
			$aliasedServices
		);
	}

}
