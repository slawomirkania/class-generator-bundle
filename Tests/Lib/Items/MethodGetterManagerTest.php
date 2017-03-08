<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * MethodGetterManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodGetterManagerTest extends BaseManager
{

    /**
     * @var MethodGetterManager
     */
    protected $methodGetterManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();

        $methods = $this->prepareClassManager()->getMethods();
        $methods->next();
        $this->methodGetterManager = $methods->current();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager', $this->methodGetterManager);
        $this->assertEquals('getFullName', $this->methodGetterManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterManager);
        $this->assertEquals(0, $errors->count());
    }
}
