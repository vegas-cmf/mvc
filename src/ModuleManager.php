<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc;

use Phalcon\Config;
use Vegas\Di\InjectionAwareTrait;
use Vegas\Stdlib\Path;

/**
 * Class ModuleManager
 * @package Vegas\Mvc
 */
class ModuleManager implements \Phalcon\Di\InjectionAwareInterface
{
    /**
     * @var string
     */
    const MODULE_BOOTSTRAP = 'Module';

    /**
     * @var string
     */
    const MODULE_CONFIG_DIR = 'Config';

    /**
     *
     */
    use InjectionAwareTrait;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var string
     */
    protected $modulesDirectory;

    /**
     * ModuleManager constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param $modulesDirectory
     */
    public function setModulesDirectory($modulesDirectory)
    {
        $this->modulesDirectory = $modulesDirectory;
    }

    /**
     * @return string
     */
    public function getModulesDirectory()
    {
        return $this->modulesDirectory;
    }

    /**
     * @param array $modules
     */
    public function registerModules(array $modules)
    {
        $availableModules = [];
        foreach ($modules as $moduleName => &$moduleConfig) {
            if (!is_string($moduleName)) {
                $moduleName = $moduleConfig;
                $moduleConfig = [];
            }

            if (!isset($moduleConfig['path'])) {
                $moduleConfig['path'] = Path::join(
                    $this->application->getApplicationDirectory(),
                    $this->getModulesDirectory(),
                    $moduleName,
                    self::MODULE_BOOTSTRAP . '.php'
                );
            }

            if (!isset($moduleConfig['viewsDir']) || $moduleConfig['viewsDir'] !== false) {
                $moduleConfig['viewsDir'] = Path::join(
                    $this->getModulesDirectory(),
                    $moduleName,
                    'View'
                );
            }

            if (!isset($moduleConfig['className'])) {
                $moduleConfig['className'] = sprintf('%s\\%s', $moduleName, self::MODULE_BOOTSTRAP);
            }

            $moduleConfig['name'] = $moduleName;

            $moduleConfig['dir'] = dirname($moduleConfig['path']);
            $availableModules[$moduleName] = $moduleConfig;
        }

        $this->application->registerModules($availableModules, true);
    }

    /**
     * @param array $modules
     * @return Config
     */
    public function getConfigs(array $modules)
    {
        $config = new Config();

        foreach ($modules as $moduleName => $moduleConfig) {
            $configPath = Path::join($moduleConfig['dir'], self::MODULE_CONFIG_DIR, 'config.php');
            if (file_exists($configPath)) {
                $moduleConfig = require($configPath);
                if (!$moduleConfig instanceof Config) {
                    $moduleConfig = new Config($moduleConfig);
                }

                $config->merge($moduleConfig);
            }
        }

        return $config;
    }
}