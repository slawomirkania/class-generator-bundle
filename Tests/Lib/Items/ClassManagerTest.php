<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * ClassManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassManagerTest extends BaseManager
{

    /**
     * @var ClassManager
     */
    private $classManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->classManager = $this->preapareClassManager();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->classManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager', $this->classManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface', $this->classManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface', $this->classManager);
        $this->assertEquals("User entity for tests", $this->classManager->getComment());
        $this->assertEquals("\AppBundle\Entity\User", $this->classManager->getNamespace());
        $this->assertEquals("\AppBundle\Entity", $this->classManager->getNamespaceWithoutName());
        $this->assertEquals("AppBundle\Entity", $this->classManager->getNamespaceWithoutNameAndBackslashPrefix());
        $this->assertEquals("User", $this->classManager->getName());
        $this->assertEquals("/AppBundle/Entity", $this->classManager->getDirectory());
        $this->assertTrue($this->classManager->hasInterface());
        $this->assertTrue($this->classManager->hasTestClass());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->classManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyClassManager()
    {
        $errors = $this->getValidator()->validate(new ClassManager());
        $this->assertEquals(3, $errors->count());
    }

    public function testValidManagerWhenInvalidMethod()
    {
        $methods = $this->classManager->getMethods();
        $methods->add(new MethodGetterManager($this->classManager)); // broken method
        $this->classManager->setMethods($methods);
        $errors = $this->getValidator()->validate($this->classManager);
        $this->assertEquals(1, $errors->count());
    }

    public function testValidManagerWhenInvalidProperty()
    {
        $properties = $this->classManager->getProperties();
        $properties->add(new PropertyManager($this->classManager)); // broken property
        $this->classManager->setProperties($properties);
        $errors = $this->getValidator()->validate($this->classManager);
        $this->assertEquals(4, $errors->count());
    }

    public function testValidManagerWhenInvalidInterfaceMethod()
    {
        $interface = $this->classManager->getInterface();
        $interfaceMethods = $interface->getMethods();
        $interfaceMethods->add(new MethodGetterInterfaceManager($this->classManager)); // broken interface method
        $interface->setMethods($interfaceMethods);
        $errors = $this->getValidator()->validate($this->classManager);
        $this->assertEquals(1, $errors->count());
    }

    public function testValidManagerWhenInvalidTestClassMethod()
    {
        $testClass = $this->classManager->getTestClass();
        $testClassMethods = $testClass->getMethods();
        $testClassMethods->add(new TestMethodManager($this->classManager)); // broken test class method
        $testClass->setMethods($testClassMethods);
        $errors = $this->getValidator()->validate($this->classManager);
        $this->assertEquals(1, $errors->count());
    }
}
