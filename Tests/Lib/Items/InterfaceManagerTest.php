<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * InterfaceManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class InterfaceManagerTest extends BaseManager
{

    /**
     * @var InterfaceManager
     */
    protected $interfaceManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->interfaceManager = $this->prepareClassManager()->getInterface();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->interfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager', $this->interfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface', $this->interfaceManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface', $this->interfaceManager);
        $this->assertEquals("Interface for entity : \AppBundle\Entity\User", $this->interfaceManager->getComment());
        $this->assertEquals("\AppBundle\Entity\UserInterface", $this->interfaceManager->getNamespace());
        $this->assertEquals("UserInterface", $this->interfaceManager->getName());
        $this->assertEquals("/AppBundle/Entity", $this->interfaceManager->getDirectory());
        $this->assertEquals("\AppBundle\Entity", $this->interfaceManager->getNamespaceWithoutName());
        $this->assertEquals("AppBundle\Entity", $this->interfaceManager->getNamespaceWithoutNameAndBackslashPrefix());
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->interfaceManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyClassManager()
    {
        $this->interfaceManager->setClassManager(new ClassManager());
        $errors = $this->getValidator()->validate($this->interfaceManager);
        $this->assertEquals(4, $errors->count());
    }

    public function testValidManagerWhenInvalidMethod()
    {
        $methods = $this->interfaceManager->getMethods();
        $methods->add(new MethodGetterInterfaceManager($this->interfaceManager->getClassManager())); // broken method
        $this->interfaceManager->setMethods($methods);
        $errors = $this->getValidator()->validate($this->interfaceManager);
        $this->assertEquals(1, $errors->count());
    }
}
