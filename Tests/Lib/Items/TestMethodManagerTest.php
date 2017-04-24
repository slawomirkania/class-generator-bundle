<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * TestMethodManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestMethodManagerTest extends BaseManager
{

    /**
     * @var TestMethodManager
     */
    protected $testMethodManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->testMethodManager = $this->prepareClassManager()->getTestClass()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->testMethodManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->testMethodManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager', $this->testMethodManager);
        $this->assertEquals('testSetFullName', $this->testMethodManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->testMethodManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyMethod()
    {
        $testMethodManager = $this->testMethodManager;
        $testMethodManager->setMethod(new MethodGetterManager($this->prepareClassManager()));

        $errors = $this->getValidator()->validate($testMethodManager);
        $this->assertEquals(1, $errors->count());
    }
}
