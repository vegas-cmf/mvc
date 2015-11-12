<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Service;

use Phalcon\DI\InjectionAwareInterface;

class Foo
{
    public function __construct($params)
    {
        print_r($params);
    }

    public function initialize()
    {

    }

    public function bar()
    {
        echo 1;
    }
}