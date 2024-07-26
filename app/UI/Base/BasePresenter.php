<?php

declare(strict_types=1);

namespace App\UI\Base;

use Nette;
use Nette\ComponentModel\IComponent;
use Nette\DI\Container;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var Container @inject */
    public $container;

    protected function createComponent(string $name): ?IComponent
    {
        $class = 'App\\UI\\Controls\\' . ucfirst($name);

        if (class_exists($class)) {
            return $this->container->getByType($class);
        }

        return parent::createComponent($name);
    }
}
