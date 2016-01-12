<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Helper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * StructureGenerator Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureGeneratorTest extends KernelTestCase
{

    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    public function testParseToArray()
    {
        $structureGenerator = $this->container->get('seg.structure_generator');
        $result = $structureGenerator->parseToArray(Helper::getStructureYaml());
        $this->assertEquals(2, count($result));
        $classesManagers = $structureGenerator->buildEntitiesClassStructure($result);
        $this->assertEquals(2, count($classesManagers));

        foreach ($classesManagers as $classManager) {
            $this->checkCommonClassManager($classManager);
        }

        $userEntity = $classesManagers[0];
        $this->assertEquals(7, $userEntity->getProperties()->count());
        $this->assertEquals(15, $userEntity->getMethods()->count()); // getters + setters + boolean

        $userEntityInterface = $userEntity->getInterface();
        $this->assertEquals(15, $userEntityInterface->getMethods()->count());

        $userEntityTestClass = $userEntity->getTestClass();
        $this->assertEquals(15, $userEntityTestClass->getMethods()->count());


        $postEntity = $classesManagers[1];
        $this->assertEquals(3, $postEntity->getProperties()->count());
        $this->assertEquals(6, $postEntity->getMethods()->count()); // getters + setters

        $postEntityInterface = $postEntity->getInterface();
        $this->assertEquals(6, $postEntityInterface->getMethods()->count());

        $postEntityTestClass = $postEntity->getTestClass();
        $this->assertEquals(6, $postEntityTestClass->getMethods()->count());
    }

    private function checkCommonClassManager(ClassManager $classManager)
    {
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager", $classManager);
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $classManager);
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface", $classManager);
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface", $classManager);
        $this->assertTrue($classManager->hasInterface());
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager", $classManager->getInterface());
        $this->assertTrue($classManager->hasTestClass());
        $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager", $classManager->getTestClass());
        $this->assertTrue($classManager->hasUniquePropertiesNames());

        $this->assertInstanceOf("\Doctrine\Common\Collections\ArrayCollection", $classManager->getProperties());
        $this->assertTrue($classManager->getProperties()->count() > 0);

        $this->assertInstanceOf("\Doctrine\Common\Collections\ArrayCollection", $classManager->getMethods());
        $this->assertTrue($classManager->getMethods()->count() > 0);

        $this->checkAllProperties($classManager->getProperties());
        $this->checkAllMethods($classManager->getMethods());
        $this->checkAllMethods($classManager->getInterface()->getMethods());
        $this->checkAllTestMethods($classManager->getTestClass()->getMethods());
    }

    private function checkAllProperties(ArrayCollection $properties)
    {
        foreach ($properties as $property) {
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager", $property);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $property);
        }
    }

    private function checkAllMethods(ArrayCollection $methods)
    {
        foreach ($methods as $method) {
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager", $method->getProperty());
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager", $method->getClassManager());
        }
    }

    private function checkAllTestMethods(ArrayCollection $methods)
    {
        foreach ($methods as $method) {
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface", $method);
            $this->assertInstanceOf("\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodManager", $method->getMethod());
        }
    }
}
