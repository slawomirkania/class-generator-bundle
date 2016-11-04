<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * TestMethodManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestMethodManagerTest extends BaseManager
{

    /**
     * @var TestMethodManager
     */
    private $testMethodManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->testMethodManager = $this->preapareClassManager()->getTestClass()->getMethods()->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->testMethodManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface', $this->testMethodManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager', $this->testMethodManager);
        $this->assertEquals('testSetFullName', $this->testMethodManager->getPreparedName());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->testMethodManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyMethod()
    {
        $testMethodManager = $this->testMethodManager;
        $testMethodManager->setMethod(new MethodGetterManager($this->preapareClassManager()));

        $errors = $this->getValidator()->validate($testMethodManager);
        $this->assertEquals(1, $errors->count());
    }
}
