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

namespace Vegas\Tests\Mvc\Component;


use Vegas\Tests\ApplicationTestCase;

class ComponentTest extends ApplicationTestCase
{
    /**
     * Render behavior testing
     */

    public function testComponentWillRenderDefaultView()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $templateContents = file_get_contents(TESTS_ROOT_DIR . '/fixtures/app/modules/Test/Component/View/Table/table.phtml');

        $this->assertEquals($templateContents, $component->getRender());
        $this->assertEquals($templateContents, (string)$component);
    }

    public function testComponentWillRenderCustomView()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $templateContents = 'this template contains only text';

        $component->customContent = $templateContents;
        $this->assertEquals($templateContents, $component->datagrid());
    }

    public function testComponentCanUseCustomViewDirectory()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $customViewPath = TESTS_ROOT_DIR . '/fixtures/app/layouts/partials/';
        $component->setViewPath($customViewPath);

        $templateContents = file_get_contents($customViewPath . 'test.phtml');

        $this->assertEquals($templateContents, $component->getRender('test'));
    }

    /**
     * Init behavior testing
     */

    /**
     * Test that component will not be initialized only by resolving.
     */
    public function testComponentWillBeResolvedWithoutInitialization()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $this->assertFalse($component->isInitialized());
    }

    /**
     * Test DI will give a fresh instance every time we ask for Component service
     */
    public function testWillGetCleanInstanceEachTime()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $newComponent = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $newComponent);

        $this->assertNotSame($component, $newComponent);
    }

    /**
     * Test each object is being setup once only before rendering multiple times.
     */
    public function testComponentIsInitializedAutomaticallyOnceByDefault()
    {
        /** @var \Test\Component\Table $component */
        $component = $this->di->get('Test\Component\Table');
        $this->assertInstanceOf('\Test\Component\Table', $component);

        $this->assertFalse($component->isInitialized());
        $this->assertEquals(0, $component->initCounter);

        $component->getRender();
        $this->assertTrue($component->isInitialized());
        $this->assertEquals(1, $component->initCounter);

        $component->getRender();
        $this->assertTrue($component->isInitialized());
        $this->assertEquals(1, $component->initCounter);

        $component->invalidate();
        $this->assertFalse($component->isInitialized());
        $component->getRender();
        $this->assertEquals(2, $component->initCounter);

        unset($component->initCounter);
        $this->assertTrue(!isset($component->initCounter));
    }
}