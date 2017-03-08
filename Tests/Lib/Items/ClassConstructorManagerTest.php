<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

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
    protected $constructorManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->constructorManager = $this->prepareClassManager()->getConstructor();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->constructorManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager', $this->constructorManager);
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
