<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * MethodGetterBooleanInterfaceManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodGetterBooleanInterfaceManagerTest extends BaseManager
{

    /**
     * @var MethodGetterBooleanInterfaceManager
     */
    protected $methodGetterBooleanInterfaceManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->methodGetterBooleanInterfaceManager = $this->prepareClassManager()->getInterface()->getMethods()->get(4);
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterBooleanInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterBooleanInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterBooleanInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanInterfaceManager', $this->methodGetterBooleanInterfaceManager);
        $this->assertEquals('isActive', $this->methodGetterBooleanInterfaceManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterBooleanInterfaceManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyProperty()
    {
        $errors = $this->getValidator()->validate(new MethodGetterBooleanInterfaceManager($this->prepareClassManager()));
        $this->assertEquals(1, $errors->count());
    }

    public function testValidManagerWhenEmptyClassManager()
    {
        $this->methodGetterBooleanInterfaceManager->setClassManager(new ClassManager());
        $errors = $this->getValidator()->validate($this->methodGetterBooleanInterfaceManager);
        $this->assertEquals(3, $errors->count());
    }
}
