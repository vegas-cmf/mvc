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
    public function beforeMatch($uri, \Vegas\Mvc\Router\Route $route);

    /**
     * @param $uri
     * @param Route $route
     * @return mixed
     */
    public function afterMatch($uri, \Vegas\Mvc\Router\Route $route);
}