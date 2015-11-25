<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc;

use Phalcon\Mvc\Router\Exception;
use Vegas\Mvc\Router\Route;

/**
 * Class Router
 * @package Vegas\Mvc
 */
class Router extends \Phalcon\Mvc\Router
{
    /**
     * @param string $pattern
     * @param null $paths
     * @param null $httpMethods
     * @param int|mixed $position
     * @return Route
     * @throws Exception
     */
    public function add($pattern, $paths = null, $httpMethods = null, $position = parent::POSITION_LAST)
    {
        /**
         * Every route is internally stored as a Phalcon\Mvc\Router\Route
         */
        $route = new Route($pattern, $paths, $httpMethods);
        $route->setDI($this->getDI());

        switch ($position) {

            case parent::POSITION_LAST:
                $this->_routes[] = $route;
                break;

            case parent::POSITION_FIRST:
                $this->_routes = array_merge([$route], $this->_routes);
                break;

            default:
                throw new Exception("Invalid route position");
        }

        return $route;
    }

    /**
     * @param null $paths
     * @return Router\Group
     */
    public function createGroup($paths = null)
    {
        $group = new Router\Group($paths);
        $group->setDI($this->getDI());
        return $group;
    }

    /**
     * @param null $uri
     */
    public function handle($uri = null)
    {
        parent::handle($uri);

        if ($this->_wasMatched) {
            $afterMatch = $this->_matchedRoute->getAfterMatch();
            if (is_callable($afterMatch)) {
                call_user_func($afterMatch, $uri, $this->_matchedRoute);
            }
        }
    }
}