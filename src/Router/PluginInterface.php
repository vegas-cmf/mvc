<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Router;

/**
 * Interface PluginInterface
 * @package Vegas\Mvc\Router
 */
interface PluginInterface
{
    /**
     * @param $uri
     * @return mixed
     */
    public function beforeMatch($uri, \Phalcon\Mvc\Router\Route $route);

    /**
     * @param $uri
     * @param \Phalcon\Mvc\Router\Route $route
     * @return mixed
     */
    public function afterMatch($uri, \Phalcon\Mvc\Router\Route $route);
}