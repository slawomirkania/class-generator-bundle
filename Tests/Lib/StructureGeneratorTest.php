<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleEntityGeneratorBundle\Lib\ClassConfig;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Helper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * StructureGenerator Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureGeneratorTest extends KernelTestCase
{

    public function testParseToArray()
    {
        $classesManagers = $this->getStructureFromYaml(Helper::getStructureYaml());
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

    /**
     * @dataProvider dataForTestClassManagerWithInlineConfiguration
     */
    public function testClassManagerWithInlineConfiguration(ClassManager $classManager, ClassConfig $expectedInlineClassConfig)
    {
        /* @var $item ClassManager */
        /* @var $classConfig ClassConfig */
        $classConfig = $classManager->getConfiguration();
        $this->assertInstanceOf(ClassConfig::class, $classConfig);
        $this->assertEquals($expectedInlineClassConfig->isNoInterface(), $classConfig->isNoInterface());
        $this->assertEquals($expectedInlineClassConfig->isNoPHPUnitClass(), $classConfig->isNoPHPUnitClass());

        if ($expectedInlineClassConfig->isNoInterface()) {
            $this->assertNull($classManager->getInterface());
        } else {
            $this->assertInstanceOf(InterfaceManager::class, $classManager->getInterface());
        }

        if ($expectedInlineClassConfig->isNoPHPUnitClass()) {
            $this->assertNull($classManager->getTestClass());
        } else {
            $this->assertInstanceOf(TestClassManager::class, $classManager->getTestClass());
        }
    }

    public function dataForTestClassManagerWithInlineConfiguration()
    {
        $classManagersOne = $this->getStructureFromYaml(Helper::getStructureYamlForTestInlineClassConfuration());
        $classManagersTwo = $this->getStructureFromYaml(Helper::getStructureYamlForTemplateChangeTest());

        return [
            [$classManagersOne[0], new ClassConfig(true, true)],
            [$classManagersTwo[0], new ClassConfig(false, false)]
        ];
    }

    public function testInlineConfiguration()
    {
        $classesManagers = $this->getStructureFromYaml(Helper::getStructureYamlForTestInlineClassConfuration());
        $this->assertEquals(1, count($classesManagers));
        $classManager = $classesManagers->first();
        $this->assertInstanceOf(ClassManager::class, $classManager);
        $this->assertFalse($classManager->hasInterface());
        $this->assertFalse($classManager->hasTestClass());
    }

    protected function getStructureFromYaml($yamlStructure)
    {
        self::bootKernel();
        $structureGenerator = self::$kernel->getContainer()->get('seg.structure_generator');
        $resultArray = $structureGenerator->parseToArray($yamlStructure);
        return $structureGenerator->buildEntitiesClassStructure($resultArray);
    }

    protected function checkCommonClassManager(ClassManager $classManager)
    {
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\ClassManager", $classManager);
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $classManager);
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface", $classManager);
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface", $classManager);
        $this->assertTrue($classManager->hasInterface());
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager", $classManager->getInterface());
        $this->assertTrue($classManager->hasTestClass());
        $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager", $classManager->getTestClass());
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

    protected function checkAllProperties(ArrayCollection $properties)
    {
        foreach ($properties as $property) {
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager", $property);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $property);
        }
    }

    protected function checkAllMethods(ArrayCollection $methods)
    {
        foreach ($methods as $method) {
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\MethodManager", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager", $method->getProperty());
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\ClassManager", $method->getClassManager());
        }
    }

    protected function checkAllTestMethods(ArrayCollection $methods)
    {
        foreach ($methods as $method) {
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface", $method);
            $this->assertInstanceOf("\SimpleEntityGeneratorBundle\Lib\Items\MethodManager", $method->getMethod());
        }
    }
}
