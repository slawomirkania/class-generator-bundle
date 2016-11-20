<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * MethodGetterInterfaceManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodGetterInterfaceManagerTest extends BaseManager
{

    /**
     * @var MethodGetterInterfaceManager
     */
    protected $methodGetterInterfaceManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();

        $methods = $this->preapareClassManager()->getInterface()->getMethods();
        $methods->next();
        $this->methodGetterInterfaceManager = $methods->current();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager', $this->methodGetterInterfaceManager);
        $this->assertEquals('getFullName', $this->methodGetterInterfaceManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterInterfaceManager);
        $this->assertEquals(0, $errors->count());
    }
}
