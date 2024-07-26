<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();

$configurator = new Nette\Configurator;
$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(__DIR__ . '/../log');

// Debug output
echo "Starting configuration setup...", PHP_EOL;

$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
    ->addDirectory(__DIR__ . '/../app')
    ->addDirectory(__DIR__ . '/../tests')
    ->register();

// Debug output
echo "Robot loader registered.", PHP_EOL;

$configurator->addConfig(__DIR__ . '/../config/common.neon');
$configurator->addConfig(__DIR__ . '/../config/services.neon');
$container = $configurator->createContainer();

// Debug output
echo "Container created.", PHP_EOL;

return $container;
