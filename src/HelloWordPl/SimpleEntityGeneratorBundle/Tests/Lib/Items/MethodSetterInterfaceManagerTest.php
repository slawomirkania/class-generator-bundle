<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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

        $this->methodSetterInterfaceManager = $this->preapareClassManager()->getInterface()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodSetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterInterfaceManager', $this->methodSetterInterfaceManager);
        $this->assertEquals('setFullName', $this->methodSetterInterfaceManager->getPreparedName());
        $this->assertFalse($this->methodSetterInterfaceManager->canAddTypeHinting());
    }

    public function testCanAddTypeHinting()
    {
        $this->assertTrue($this->preapareClassManager()->getInterface()->getMethods()->get(7)->canAddTypeHinting());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodSetterInterfaceManager);
        $this->assertEquals(0, $errors->count());
    }
}
