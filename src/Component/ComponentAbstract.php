<?php
/**
 * @author Radosław Fąfara <radek@amsterdamstandard.com>
 * @company Amsterdam Standard Sp. z o.o.
 */

namespace Vegas\Mvc\Component;

use Phalcon\Di\InjectionAwareInterface;
use Phalcon\Mvc\View;
use Vegas\Di\InjectionAwareTrait;
use Vegas\Stdlib\Path;

/**
 * Class ComponentAbstract
 * Abstract basis for view components - simple services which contain a view.
 * @package Vegas\Mvc\Component
 */
abstract class ComponentAbstract implements ComponentInterface, InjectionAwareInterface
{
    use InjectionAwareTrait;

    const VIEW_DIR = 'View';

    /**
     * Overrides default path where to look for templates.
     * @var string
     */
    protected $viewPath;

    /**
     * @var array
     */
    protected $viewParams = [];

    /**
     * @var bool
     */
    protected $isInitialized = false;

    /**
     * Retrieves default view path - which is PATH_TO_COMPONENT/View/__CLASS__/
     * @return string
     */
    protected function getDefaultViewPath()
    {
        $reflection = new \ReflectionObject($this);
        return Path::join(
            dirname($reflection->getFileName()),
            self::VIEW_DIR,
            $reflection->getShortName()
        );
    }

    /**
     * Gets current view path (where partials are stored)
     * @return string
     */
    protected function getViewPath()
    {
        if (!isset($this->viewPath)) {
            return $this->getDefaultViewPath();
        }

        return $this->viewPath;
    }

    /**
     * Gets all currently stored component params, available in the rendered partial
     * @return array
     */
    protected function getViewParams()
    {
        return $this->viewParams;
    }

    /**
     * Replaces used view path (where component templates are stored)
     * @param string $path
     * @return $this
     */
    public function setViewPath($path)
    {
        $this->viewPath = $path;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setViewParam($key, $value)
    {
        $this->viewParams[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getViewParam($key)
    {
        if (isset($this->viewParams[$key])) {
            return $this->viewParams[$key];
        }
        return null;
    }

    /**
     * @see setViewParam()
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        $this->setViewParam($name, $value);
    }

    /**
     * @see getViewParam()
     * {@inheritdoc}
     */
    public function __get($name)
    {
        return $this->getViewParam($name);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($name)
    {
        return isset($this->viewParams[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function __unset($name)
    {
        unset($this->viewParams[$name]);
    }

    /**
     * @see getRender()
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getRender();
    }

    /**
     * {@inheritdoc}
     */
    public function getRender($template = null, array $params = [])
    {
        $this->isInitialized || $this->initialize();

        if (empty($template)) {
            $className = (new \ReflectionObject($this))->getShortName();
            $template = mb_strtolower($className);
        }

        $view = new View;
        $view->setDI($this->getDI());
        $view->setViewsDir($this->getViewPath());

        return $view->getPartial($template, array_merge($this->getViewParams(), $params));
    }

    /**
     * Allows to re-initialize the object state before rendering.
     * @return $this
     */
    public function invalidate()
    {
        $this->isInitialized = false;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isInitialized()
    {
        return $this->isInitialized;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize()
    {
        $this->isInitialized = true;
    }
}