<?php
/**
 * This file is part of Vegas package
 *
 * @author Mateusz Aniołek <mateusz.aniolek@amsterdam-standard.pl>
 * @company Amsterdam Standard Sp. z o.o.
 * @homepage http://cmf.vegas
 */

namespace Vegas\Mvc\Di;

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;
use Phalcon\Annotations\Collection;
use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\Dispatcher;
use Vegas\Di\InjectionAwareTrait;
use Vegas\Di\Injector;
use Vegas\Mvc\Application;

/**
 * Class Manager
 * @package Vegas\Mvc\Di
 */
class Manager implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * @param $instance
     */
    public function inject(& $instance)
    {
        $reader = new MemoryAdapter();
        $reflector = $reader->get('\\' . get_class($instance));

        $annotations = $reflector->getPropertiesAnnotations();
        $this->injectToProperties($instance, $annotations);
    }

    /**
     * @param $instance
     * @param $annotations
     */
    public function injectToProperties(& $instance, $annotations)
    {
        if ($annotations) {

            /** @var Collection $property */
            foreach ($annotations as $key => $property) {

                if ($this->isInjector($property)) {
                    $injectAnnotation = $property->get('inject');
                    $injectClassName = $injectAnnotation->getArgument('class');

                    if ('\\' . get_class($instance) == $injectClassName) {
                        continue;
                    }

                    $reflectionClass = new \ReflectionClass($instance);
                    $reflectionProperty = $reflectionClass->getProperty($key);
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($instance, $this->getDI()->get($injectClassName));
                }
            }

        }
    }

    protected function isInjector(Collection $property)
    {
        return $property->has('var') && $property->has('inject');
    }

}