<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Test\Filter;

use Vegas\Mvc\Router\PluginInterface;

class IPPlugin implements PluginInterface
{
    public function beforeMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'beforeMatch!';
        return true;
    }

    public function afterMatch($uri, \Phalcon\Mvc\Router\Route $route)
    {
        echo 'afterMatch!';
        return true;
    }
}