<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\View\Engine\Volt;

/**
 * Interface HelperInterface
 * @package Vegas\Mvc\View\Engine\Volt
 */
interface FilterInterface
{
    /**
     * @return callable
     */
    public function getFilter();
}