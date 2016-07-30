<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * ClassConstructorManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassConstructorManagerTest extends BaseManager
{

    /**
     * @var ClassConstructorManager
     */
    private $constructorManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->constructorManager = $this->preapareClassManager()->getConstructor();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->constructorManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager', $this->constructorManager);
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->constructorManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenInValidClassManager()
    {
        $emptyClassManager = new ClassManager();
        $this->constructorManager->setClassManager($emptyClassManager);
        $errors = $this->getValidator()->validate($this->constructorManager);
        $this->assertEquals(3, $errors->count());
    }
}
