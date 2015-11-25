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
 * Class PluginCollectorTrait
 * @package Vegas\Mvc\Router
 */
trait PluginCollectorTrait
{
    /**
     * @var PluginInterface[]
     */
    protected $filters;

    /**
     * @var PluginInterface[]
     */
    protected $events;

    /**
     * @param PluginInterface $filter
     * @return $this
     */
    public function pushFilter(PluginInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function pushFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->pushFilter($filter);
        }
        return $this;
    }

    /**
     * @param PluginInterface $event
     * @return $this
     */
    public function pushEvent(PluginInterface $event)
    {
        $this->events[] = $event;
        return $this;
    }

    /**
     * @param array $events
     * @return $this
     */
    public function pushEvents(array $events)
    {
        foreach ($events as $event) {
            $this->pushEvent($event);
        }
        return $this;
    }

    /**
     * Sets a callback that is called if the route is matched.
     * The developer can implement any arbitrary conditions here
     * If the callback returns false the route is treated as not matched
     */
    public function getBeforeMatch()
    {
        $fn = function ($uri, $route) {
            if (!empty($this->events)) {
                foreach ($this->events as $event) {
                    $event->beforeMatch($uri, $route);
                }
            }

            $result = true;

            if (!empty($this->filters)) {
                foreach ($this->filters as $filter) {
                    $result = $filter->beforeMatch($uri, $route) && $result;
                }
            }

            if (is_callable($this->_beforeMatch)) {
                $result = call_user_func($this->_beforeMatch, $uri, $route) && $result;
            }

            return $result;
        };

        return $fn;
    }

    /**
     * Sets a callback that is called if the route is matched.
     * The developer can implement any arbitrary conditions here
     * Return value does not affect on dispatching process
     */
    public function getAfterMatch()
    {
        $fn = function ($uri, $route) {
            if (!empty($this->events)) {
                foreach ($this->events as $event) {
                    $event->afterMatch($uri, $route);
                }
            }

            $result = true;

            if (!empty($this->filters)) {
                foreach ($this->filters as $filter) {
                    $result = $filter->afterMatch($uri, $route) && $result;
                }
            }

            return $result;
        };

        return $fn;
    }

    /**
     * @return \Phalcon\DiInterface
     */
    abstract public function getDI();
}