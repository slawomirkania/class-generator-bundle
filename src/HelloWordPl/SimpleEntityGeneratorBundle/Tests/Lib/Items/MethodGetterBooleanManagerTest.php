<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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
        $this->methodGetterBooleanManager = $this->preapareClassManager()->getMethods()->get(4);
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterBooleanManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager', $this->methodGetterBooleanManager);
        $this->assertEquals('isActive', $this->methodGetterBooleanManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterBooleanManager);
        $this->assertEquals(0, $errors->count());
    }
}
