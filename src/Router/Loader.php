<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Router;

use Vegas\Mvc\ModuleManager;
use Vegas\Mvc\Router;
use Vegas\Stdlib\Path;

/**
 * Class Loader
 * @package Vegas\Mvc\Router
 */
class Loader
{
    const ROUTES_FILE = 'routes.php';

    /**
     * @param array $modules
     * @param Router $router
     * @return Router
     */
    public function autoload(array $modules, Router $router)
    {
        foreach ($modules as $moduleName => $moduleConfig) {
            $routesPath = Path::join($moduleConfig['dir'], ModuleManager::MODULE_CONFIG_DIR, self::ROUTES_FILE);
            if (file_exists($routesPath)) {
                require($routesPath);
            }
        }

        return $router;
    }
}