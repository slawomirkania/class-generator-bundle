<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * MethodGetterBooleanManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodGetterBooleanManagerTest extends BaseManager
{

    /**
     * @var MethodGetterBooleanManager
     */
    protected $methodGetterBooleanManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->methodGetterBooleanManager = $this->prepareClassManager()->getMethods()->get(4);
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager', $this->methodGetterBooleanManager);
        $this->assertEquals('isActive', $this->methodGetterBooleanManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterBooleanManager);
        $this->assertEquals(0, $errors->count());
    }
}
