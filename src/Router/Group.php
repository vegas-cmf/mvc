<?php
/**
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\Router;

/**
 * Class Group
 * @package Vegas\Mvc\Router
 */
class Group extends \Phalcon\Mvc\Router\Group
{
    use PluginCollectorTrait;

    /**
     * Adds a route applying the common attributes
     */
    protected function _addRoute($pattern, $paths = null, $httpMethods = null)
    {
        /**
         * Check if the paths need to be merged with current paths
         */
        $defaultPaths = $this->_paths;

        if (is_array($defaultPaths)) {

            if (is_string($paths)) {
                $processedPaths = Route::getRoutePaths($paths);
            } else {
                $processedPaths = $paths;
            }

            if (is_array($processedPaths)) {
                /**
                 * Merge the paths with the default paths
                 */
                $mergedPaths = array_merge($defaultPaths, $processedPaths);
            } else {
                $mergedPaths = $defaultPaths;
            }
        } else {
            $mergedPaths = $paths;
        }

        /**
         * Every route is internally stored as a Phalcon\Mvc\Router\Route
         */
        $route = new Route($this->_prefix . $pattern, $mergedPaths, $httpMethods);
        $this->_routes[] = $route;

        $route->setGroup($this);
        return $route;
    }
}