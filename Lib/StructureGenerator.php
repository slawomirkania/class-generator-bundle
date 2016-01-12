<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InitPropertyManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Yaml\Parser;

/**
 * GeneratorEntity Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureGenerator
{

    /**
     * Namespace for Serializer
     *
     * @var string
     */
    const CLASS_MANAGER_NAMESPACE = "HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager";

    /**
     * @var SerializerInterface
     */
    private $serializer = null;

    /**
     * @var Parser
     */
    private $parser = null;

    /**
     * CONSTR
     *
     * @param SerializerInterface $serializer
     * @param Parser $parser
     */
    public function __construct(SerializerInterface $serializer, Parser $parser)
    {
        $this->parser = $parser;
        $this->serializer = $serializer;
    }

    /**
     * Parse yaml string to array of JSONs
     *
     * @param string $fileContent
     * @return array
     */
    public function parseToArray($fileContent)
    {
        $parser = $this->getParser();
        $entitiesDataArray = $parser->parse($fileContent);
        $entitiesData = [];
        foreach ($entitiesDataArray as $entityDataArray) {
            $entitiesData[] = json_encode($entityDataArray, true);
        }

        return $entitiesData;
    }

    /**
     * Build Entities Class Structures from array array('{"data":"data"}', '{"data":"data"}')
     *
     * @param array $entitiesData
     * @return array
     */
    public function buildEntitiesClassStructure(array $entitiesData = [])
    {
        $classesManagers = [];
        foreach ($entitiesData as $jsonData) {
            $classesManagers[] = $this->deserializeJsonDataToClassManager($jsonData);
        }

        // building class environment
        foreach ($classesManagers as $classManager) {
            $this->preapareClassManager($classManager); // reference
        }

        return $classesManagers;
    }

    /**
     * Generate class components
     *
     * @param ClassManager $classManager
     * @return ClassManager
     */
    public function preapareClassManager(ClassManager $classManager)
    {
        $interface = new InterfaceManager($classManager);
        $constructor = new ClassConstructorManager($classManager);
        $testClass = new TestClassManager($classManager);
        $this->generateAndFillClassMethods($classManager);
        $this->prepareAndFillInitProperties($constructor);
        $this->generateAndFillInterfaceMethods($interface);
        $this->generateAndFillTestClassMethods($testClass);
        $classManager->setConstructor($constructor);
        $classManager->setInterface($interface);
        $classManager->setTestClass($testClass);

        return $classManager;
    }

    /**
     * Generate class components
     * - setters and getters for Class and Interface (optional)
     * - method with prefix is for boolean properties
     *
     * @param \HelloWordPl\SimpleEntityGeneratorBundle\Lib\ClassManager $classManager
     */
    protected function generateAndFillClassMethods(ClassManager $classManager)
    {
        $methodsForClass = new ArrayCollection();
        foreach ($classManager->getProperties() as $property) {
            if ($property->isTypeBoolean()) {
                $methodsForClass->add((new MethodGetterBooleanManager($classManager))->setProperty($property));
            }

            $methodSetterManager = new MethodSetterManager($classManager);
            $methodSetterManager->setProperty($property);
            $methodGetterManager = new MethodGetterManager($classManager);
            $methodGetterManager->setProperty($property);

            $methodsForClass->add($methodSetterManager);
            $methodsForClass->add($methodGetterManager);
        }

        $classManager->setMethods($methodsForClass);

        return $classManager;
    }

    /**
     * Generate methods for interface
     *
     * @param InterfaceManager $interface
     * @return ArrayCollection
     */
    protected function generateAndFillInterfaceMethods(InterfaceManager $interface)
    {
        $methodsForInterface = new ArrayCollection();
        $classManager = $interface->getClassManager();
        foreach ($classManager->getProperties() as $property) {
            if ($property->isTypeBoolean()) {
                $methodsForInterface->add((new MethodGetterBooleanInterfaceManager($classManager))->setProperty($property));
            }

            $methodSetterInterfaceManager = new MethodSetterInterfaceManager($classManager);
            $methodSetterInterfaceManager->setProperty($property);
            $methodGetterInterfaceManager = new MethodGetterInterfaceManager($classManager);
            $methodGetterInterfaceManager->setProperty($property);

            $methodsForInterface->add($methodSetterInterfaceManager);
            $methodsForInterface->add($methodGetterInterfaceManager);
        }

        $interface->setMethods($methodsForInterface);

        return $interface;
    }

    /**
     * Prepare list of init properties for constructor
     *
     * @param ClassConstructorManager $classConstructor
     * @return ClassConstructorManager
     */
    protected function prepareAndFillInitProperties(ClassConstructorManager $classConstructor)
    {
        $initProperties = new ArrayCollection();
        foreach ($classConstructor->getClassManager()->getProperties() as $property) {
            if (false == $property->isTypeArrayCollection()) {
                continue;
            }

            $initProperty = new InitPropertyManager();
            $initProperty->setProperty($property);

            $initProperties->add($initProperty);
        }

        $classConstructor->setInitProperties($initProperties);

        return $classConstructor;
    }

    /**
     * init test class for entity
     *
     * @param TestClassManager $testClassManager
     * @return TestClassManager
     */
    protected function generateAndFillTestClassMethods(TestClassManager $testClassManager)
    {
        $testMethods = new ArrayCollection();
        foreach ($testClassManager->getClassManager()->getMethods() as $method) {
            $testMethod = new TestMethodManager();
            $testMethod->setMethod($method);
            $testMethods->add($testMethod);
        }

        $testClassManager->setMethods($testMethods);

        return $testClassManager;
    }

    /**
     * Deserialize JSON data to class manager
     *
     * @param string $jsonClassToDeserialize
     * @return ClassManagerserializeJsonDataToClassManager($jsonClassToDeserialize)
     */
    protected function deserializeJsonDataToClassManager($jsonClassToDeserialize)
    {
        return $this->getSerializer()->deserialize($jsonClassToDeserialize, self::CLASS_MANAGER_NAMESPACE, 'json');
    }

    /**
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @return Parser
     */
    protected function getParser()
    {
        return $this->parser;
    }
}
