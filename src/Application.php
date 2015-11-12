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
use Phalcon\Events\Manager;
use Phalcon\Http\ResponseInterface;
use Vegas\Mvc\ModuleManager\EventListener\Boot as ModuleManagerBootEventListener;
use Vegas\Mvc\Router\EventListener\Boot as RouterBootEventListener;
use Vegas\Mvc\Autoloader\EventListener\Boot as AutoloaderBootEventListener;
use Vegas\Mvc\View\EventListener\Boot as ViewBootEventListener;
use Vegas\Mvc\Router;

/**
 * Class Application
 * @package Vegas\Mvc
 */
class Application extends \Phalcon\Mvc\Application
{
    /**
     * @var string
     */
    protected $applicationDirectory;

    /**
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var bool
     */
    protected $isBootstrapped = false;

    /**
     * Application constructor.
     * @param \Phalcon\DiInterface|null $dependencyInjector
     * @param Config $config
     */
    public function __construct(\Phalcon\DiInterface $dependencyInjector = null, Config $config)
    {
        parent::__construct($dependencyInjector);
        $this->config = $config;
        $this->_eventsManager = new Manager();

        $this->attachBootstrapEvents();
    }

    /**
     * @param $applicationDirectory
     */
    public function setApplicationDirectory($applicationDirectory)
    {
        $this->applicationDirectory = $applicationDirectory;
    }

    /**
     * @return string
     */
    public function getApplicationDirectory()
    {
        return $this->applicationDirectory;
    }

    /**
     * @return mixed
     */
    public function getModuleManager()
    {
        return $this->moduleManager;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return $this
     */
    protected function attachBootstrapEvents()
    {
        $this->getEventsManager()->attach('application', new ModuleManagerBootEventListener());
        $this->getEventsManager()->attach('application', new RouterBootEventListener());
        $this->getEventsManager()->attach('application', new AutoloaderBootEventListener());
        $this->getEventsManager()->attach('application', new ViewBootEventListener());

        return $this;
    }

    /**
     * Triggers the bootstrap process autoloading modules
     * @return bool
     * @throws \Exception
     */
    public function bootstrap()
    {
        $di = $this->di;
        if (!is_object($di)) {
            throw new \Exception("A dependency injection object is required to access internal services");
        }

        $eventsManager = $this->_eventsManager;

        /**
         * Call boot event, this allow the developer to perform initialization actions
         */
        if ($eventsManager instanceof Manager) {
            if ($eventsManager->fire("application:boot", $this) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param null $uri
     * @return mixed|object
     * @throws \Exception
     */
    public function handle($uri = null)
    {
        /**
         * Allow one bootstrap per application instance
         */
        if (!$this->isBootstrapped) {
            $this->isBootstrapped = $this->bootstrap();
        }

        /**
         * Refuse to continue if boot process failed
         */
        if (!$this->isBootstrapped) {
            return false;
        }

        $di = $this->di;

        $eventsManager = $this->_eventsManager;

        $router = $di->getShared("router");

        /**
         * Handle the URI pattern (if any)
         */
        $router->handle($uri);

        /**
         * If the router doesn't return a valid module we use the default module
         */
        $moduleName = $router->getModuleName();
        if (!$moduleName) {
            $moduleName = $this->_defaultModule;
        }

        $moduleObject = null;

        /**
         * Process the module definition
         */
        if ($moduleName) {

            if ($eventsManager instanceof Manager) {
                if ($eventsManager->fire("application:beforeStartModule", $this, $moduleName) === false) {
                    return false;
                }
            }

            /**
             * Gets the module definition
             */
            $module = $this->getModule($moduleName);

            /**
             * A module definition must ne an array or an object
             */
            if (!is_array($module) && !$module instanceof \Phalcon\Mvc\ModuleDefinitionInterface) {
                throw new \Exception("Invalid module definition");
            }

            /**
             * An array module definition contains a path to a module definition class
             */
            if (is_array($module)) {

                /**
                 * Class name used to load the module definition
                 */
                $className = isset($module['className']) ? $module['className'] : ModuleManager::MODULE_BOOTSTRAP;

                $moduleObject = $di->get($className);

                /**
                 * 'registerAutoloaders' and 'registerServices' are automatically called
                 */
                $moduleObject->registerAutoloaders($di);
                $moduleObject->registerServices($di);

            } else {

                /**
                 * A module definition object, can be a Closure instance
                 */
                if ($module instanceof \Closure) {
                    $moduleObject = call_user_func_array($module, [$di]);
                } else {
                    throw new \Exception("Invalid module definition");
                }
            }

            /**
             * Calling afterStartModule event
             */
            if ($eventsManager instanceof Manager) {
                $eventsManager->fire("application:afterStartModule", $this, $moduleObject);
            }

        }

        /**
         * We get the parameters from the router and assign them to the dispatcher
         * Assign the values passed from the router
         */
        $dispatcher = $di->getShared("dispatcher");
        $dispatcher->setDefaultNamespace(sprintf('%s\\Controller', $router->getModuleName()));

        $dispatcher->setModuleName($router->getModuleName());
        $dispatcher->setNamespaceName($router->getNamespaceName());
        $dispatcher->setControllerName($router->getControllerName());
        $dispatcher->setActionName($router->getActionName());
        $dispatcher->setParams($router->getParams());

        if ($di->has('view') && $this->_implicitView) {
            $di->get('view')->start();
        }

        /**
         * Calling beforeHandleRequest
         */
        if ($eventsManager instanceof Manager) {
            if ($eventsManager->fire("application:beforeHandleRequest", $this, $dispatcher) === false) {
                return false;
            }
        }

        /**
         * The dispatcher must return an object
         */
        $controller = $dispatcher->dispatch();

        /**
         * Get the latest value returned by an action
         */
        $possibleResponse = $dispatcher->getReturnedValue();

        if (gettype($possibleResponse) === 'boolean' && $possibleResponse == false) {
            $response = $di->getShared("response");
        } else {
            if (is_object($possibleResponse)) {

                /**
                 * Check if the returned object is already a response
                 */
                $returnedResponse = $possibleResponse instanceof ResponseInterface;
            } else {
                $returnedResponse = false;
            }

            /**
             * Calling afterHandleRequest
             */
            if ($eventsManager instanceof Manager) {
                $eventsManager->fire("application:afterHandleRequest", $this, $controller);
            }

            /**
             * If the dispatcher returns an object we try to render the view in auto-rendering mode
             */
            if (!$returnedResponse) {
                if ($di->has('view') && $this->_implicitView === true) {
                    if (is_object($controller)) {

                        $renderStatus = true;

                        /**
                         * This allows to make a custom view render
                         */
                        if ($eventsManager instanceof Manager) {
                            $renderStatus = $eventsManager->fire("application:viewRender", $this, $di->get('view'));
                        }

                        /**
                         * Check if the view process has been treated by the developer
                         */
                        if ($renderStatus !== false) {

                            /**
                             * Automatic render based on the latest controller executed
                             */
                            if (isset($module)) {
                                $di->get('view')->render(
                                    sprintf(
                                        '%s/%s',
                                        $module['viewsDir'],
                                        ltrim(str_replace('\\', '/', $dispatcher->getControllerName()), '/')
                                    ),
                                    $dispatcher->getActionName(),
                                    $dispatcher->getParams()
                                );
                                $di->get('view')->setViewsDir(APP_ROOT . '/app/');
                            } else {
                                $di->get('view')->render(
                                    $dispatcher->getControllerName(),
                                    $dispatcher->getActionName(),
                                    $dispatcher->getParams()
                                );
                            }
                        }
                    }
                }
            }

            /**
             * Finish the view component (stop output buffering)
             */
            if ($di->has('view') && $this->_implicitView === true) {
                $di->get('view')->finish();
            }

            if (!$returnedResponse) {

                $response = $di->getShared("response");
                if ($this->_implicitView === true) {

                    /**
                     * The content returned by the view is passed to the response service
                     */
                    $response->setContent($di->get('view')->getContent());
                }

            } else {

                /**
                 * We don't need to create a response because there is one already created
                 */
                $response = $possibleResponse;
            }
        }

        /**
         * Calling beforeSendResponse
         */
        if ($eventsManager instanceof Manager) {
            $eventsManager->fire("application:beforeSendResponse", $this, $response);
        }

        /**
         * Headers and Cookies are automatically send
         */
        $response->sendHeaders();
        $response->sendCookies();

        /**
         * Return the response
         */
        return $response;
    }
}