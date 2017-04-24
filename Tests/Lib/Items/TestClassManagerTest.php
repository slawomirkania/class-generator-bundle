<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * TestClassManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestClassManagerTest extends BaseManager
{

    /**
     * @var TestClassManager
     */
    protected $testClassManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->testClassManager = $this->prepareClassManager()->getTestClass();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->testClassManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface', $this->testClassManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface', $this->testClassManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager', $this->testClassManager);
        $this->assertEquals('Test for \AppBundle\Entity\User', $this->testClassManager->getComment());
        $this->assertEquals('/AppBundle/Tests/Entity', $this->testClassManager->getDirectory());
        $this->assertEquals('UserTest', $this->testClassManager->getName());
        $this->assertEquals('\AppBundle\Tests\Entity\UserTest', $this->testClassManager->getNamespace());
        $this->assertEquals('\AppBundle\Tests\Entity', $this->testClassManager->getNamespaceWithoutName());
        $this->assertEquals('AppBundle\Tests\Entity', $this->testClassManager->getNamespaceWithoutNameAndBackslashPrefix());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->testClassManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenInvalidTestMethod()
    {
        $methods = $this->testClassManager->getMethods();
        $methods->add(new TestMethodManager());
        $this->testClassManager->setMethods($methods);
        $errors = $this->getValidator()->validate($this->testClassManager);
        $this->assertEquals(1, $errors->count());
    }

    public function testValidManagerWhenInvalidClassManager()
    {
        $this->testClassManager->setClassManager(new ClassManager());
        $errors = $this->getValidator()->validate($this->testClassManager);
        $this->assertEquals(3, $errors->count());
    }
}
