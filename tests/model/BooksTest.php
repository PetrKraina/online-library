<?php

namespace Tests\Model;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../bootstrap.php';

class BooksTest extends TestCase
{
    private $container;

    public function __construct()
    {
        $this->container = require __DIR__ . '/../bootstrap.php';
    }

    public function testSomeFunctionality()
    {
        $books = $this->container->getByType(\App\Model\Books::class);
		echo "Books class: ", get_class($books), PHP_EOL;
		Assert::true(is_numeric($books->count()));
    }
}

(new BooksTest)->run();
