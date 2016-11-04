<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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
    private $methodSetterManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->methodSetterManager = $this->preapareClassManager()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface', $this->methodSetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodSetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager', $this->methodSetterManager);
        $this->assertEquals('setFullName', $this->methodSetterManager->getPreparedName());
        $this->assertFalse($this->methodSetterManager->canAddTypeHinting());
    }

    public function testCanAddTypeHinting()
    {
        $this->assertTrue($this->preapareClassManager()->getMethods()->get(7)->canAddTypeHinting());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodSetterManager);
        $this->assertEquals(0, $errors->count());
    }
}
