<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * TestMethodManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodSetterInterfaceManagerTest extends BaseManager
{

    /**
     * @var MethodSetterManager
     */
    protected $methodSetterInterfaceManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();

        $this->methodSetterInterfaceManager = $this->prepareClassManager()->getInterface()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterInterfaceManager', $this->methodSetterInterfaceManager);
        $this->assertEquals('setFullName', $this->methodSetterInterfaceManager->getPreparedName());
        $this->assertFalse($this->methodSetterInterfaceManager->canAddTypeHinting());
    }

    public function testCanAddTypeHinting()
    {
        $this->assertTrue($this->prepareClassManager()->getInterface()->getMethods()->get(7)->canAddTypeHinting());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodSetterInterfaceManager);
        $this->assertEquals(0, $errors->count());
    }
}
