<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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

        $methods = $this->prepareClassManager()->getInterface()->getMethods();
        $methods->next();
        $this->methodGetterInterfaceManager = $methods->current();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterInterfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager', $this->methodGetterInterfaceManager);
        $this->assertEquals('getFullName', $this->methodGetterInterfaceManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterInterfaceManager);
        $this->assertEquals(0, $errors->count());
    }
}
