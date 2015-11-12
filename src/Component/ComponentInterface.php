<?php
/**
 * This file is part of Vegas package
 *
 * @author Radosław Fąfara <radek@amsterdamstandard.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://cmf.vegas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Mvc\Component;

/**
 * Interface ComponentInterface
 * Common interface for for view components - simple services which contain a view.
 * @package Vegas\Mvc\Component
 */
interface ComponentInterface
{
    /**
     * Will retrieve rendered content of the component
     * @param string $template name of custom template for the component
     * @param array $params extra params which can override component state
     * @return string
     */
    public function getRender($template = null, array $params = []);

    /**
     * Allows to do custom initialization process for this component (like set data providers etc.).
     * By default it should be done once per component instance.
     *
     * Use it explicitely inside controllers when it needs to be done before rendering.
     */
    public function initialize();

    /**
     * Allows checks whether the component is populated by data
     * @return bool
     */
    public function isInitialized();

    /**
     * Allows to set up view property in component
     * {@inheritdoc}
     */
    public function __set($name, $value);

    /**
     * Allows to get a property outside component's view
     * All of the properties should be available inside as well.
     * {@inheritdoc}
     */
    public function __get($name);
}