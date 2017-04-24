<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * MethodSetterManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodSetterManagerTest extends BaseManager
{

    /**
     * @var MethodSetterManager
     */
    protected $methodSetterManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->methodSetterManager = $this->prepareClassManager()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodSetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager', $this->methodSetterManager);
        $this->assertEquals('setFullName', $this->methodSetterManager->getPreparedName());
        $this->assertFalse($this->methodSetterManager->canAddTypeHinting());
    }

    public function testCanAddTypeHinting()
    {
        $this->assertTrue($this->prepareClassManager()->getMethods()->get(7)->canAddTypeHinting());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodSetterManager);
        $this->assertEquals(0, $errors->count());
    }
}
