<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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
    private $methodGetterManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();

        $methods = $this->preapareClassManager()->getMethods();
        $methods->next();
        $this->methodGetterManager = $methods->current();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->methodGetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->methodGetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager', $this->methodGetterManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager', $this->methodGetterManager);
        $this->assertEquals('getFullName', $this->methodGetterManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->methodGetterManager);
        $this->assertEquals(0, $errors->count());
    }
}
