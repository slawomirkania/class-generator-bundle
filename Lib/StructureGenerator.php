<?php

namespace SimpleEntityGeneratorBundle\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use SimpleEntityGeneratorBundle\Lib\Builders\DerivedMethodsBuilder;
use SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\InitPropertyManager;
use SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodDerivedFromInterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodForPropertyManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanInterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodSetterInterfaceManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use Symfony\Component\Yaml\Parser;

/**
 * GeneratorEntity Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureGenerator
{

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
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Parse yaml string to array of JSONs
     *
     * @param string $fileContent
     * @return ArrayCollection
     */
    public function parseToArray($fileContent)
    {
        $parser = $this->getParser();
        $entitiesDataArray = $parser->parse($fileContent);
        $entitiesData = new ArrayCollection();
        foreach ($entitiesDataArray as $entityDataArray) {
            $entitiesData->add(json_encode($entityDataArray, true));
        }

        return $entitiesData;
    }

    /**
     * Build Entities Class Structures from array array('{"data":"data"}', '{"data":"data"}')
     *
     * @param ArrayCollection $entitiesData
     * @param ClassConfig $classConfig
     * @return ArrayCollection
     */
    public function buildEntitiesClassStructure(ArrayCollection $entitiesData, ClassConfig $classConfig = null)
    {
        $classConfig = $this->getDefaultClassConfigIfNeed($classConfig);
        $classesManagers = new ArrayCollection();
        foreach ($entitiesData as $jsonData) {
            $classesManagers->add($this->deserializeJsonDataToClassManager($jsonData));
        }

        // building class environment
        foreach ($classesManagers as $classManager) {
            $this->prepareClassManager($classManager, $classConfig); // reference
        }

        return $classesManagers;
    }

    /**
     * Generate class components
     *
     * @param ClassManager $classManager
     * @param ClassConfig $classConfig
     * @return ClassManager
     */
    public function prepareClassManager(ClassManager $classManager, ClassConfig $classConfig = null)
    {
        $inClassConfiguration = $classManager->getConfiguration();
        $defaultClassConfiguration = $this->getDefaultClassConfigIfNeed($classConfig);

        $constructor = new ClassConstructorManager($classManager);
        $this->generateAndFillClassMethods($classManager);
        $this->prepareAndFillInitProperties($constructor);
        $classManager->setConstructor($constructor);

        // inline config is more important
        if ($inClassConfiguration instanceof ClassConfig) {
            $canAddInterface = !$inClassConfiguration->isNoInterface();
            $canPHPUnitClass = !$inClassConfiguration->isNoPHPUnitClass();
        } else {
            $canAddInterface = !$defaultClassConfiguration->isNoInterface();
            $canPHPUnitClass = !$defaultClassConfiguration->isNoPHPUnitClass();
        }

        if ($canAddInterface) {
            $interface = new InterfaceManager($classManager);
            $this->generateAndFillInterfaceMethods($interface);
            $classManager->setInterface($interface);
        }
        if ($canPHPUnitClass) {
            $testClass = new TestClassManager($classManager);
            $this->generateAndFillTestClassMethods($testClass);
            $classManager->setTestClass($testClass);
        }

        return $classManager;
    }

    /**
     * Generate class components
     * - setters and getters for Class and Interface (optional)
     * - method with prefix is for boolean properties
     *
     * @param ClassManager $classManager
     * @return ClassManager
     */
    protected function generateAndFillClassMethods(ClassManager $classManager)
    {
        $methodsForClass = new ArrayCollection();

        // fix - jms serializer does not call ClassManager constructor during deserialization
        if (false === ($classManager->getProperties() instanceof ArrayCollection)) {
            $classManager->setProperties(new ArrayCollection());
        }

        $this->appendPropertiesMethods($classManager, $methodsForClass);
        $this->appendMethodsDerivedFromInterface($classManager, $methodsForClass);

        $classManager->setMethods($methodsForClass);

        return $classManager;
    }

    protected function appendPropertiesMethods(ClassManager $classManager, ArrayCollection $appendTo)
    {
        foreach ($classManager->getProperties() as $property) {
            if ($property->isTypeBoolean()) {
                $appendTo->add((new MethodGetterBooleanManager($classManager))->setProperty($property));
            }

            $methodSetterManager = new MethodSetterManager($classManager);
            $methodSetterManager->setProperty($property);
            $methodGetterManager = new MethodGetterManager($classManager);
            $methodGetterManager->setProperty($property);

            $appendTo->add($methodSetterManager);
            $appendTo->add($methodGetterManager);
        }
    }

    protected function appendMethodsDerivedFromInterface(ClassManager $classManager, ArrayCollection $appendTo)
    {
        $methodsToSkip = [];
        foreach($appendTo as $method) {
            $methodsToSkip[] = $method->getPreparedName();
        }
        foreach ($classManager->getImplements() as $namespace) {
            $builder = new DerivedMethodsBuilder($namespace, $classManager);
            $builder->setMethodsToSkip($methodsToSkip);
            foreach($builder->getMethodsDerivedFromInterface() as $derivedMethodManager) {
                $appendTo->add($derivedMethodManager);
            }
        }
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
            if (false === $property->isTypeArrayCollection()) {
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
            $this->buildAndAppendTestMethodIfNecessary($method, $testMethods);
        }

        $testClassManager->setMethods($testMethods);

        return $testClassManager;
    }

    protected function buildAndAppendTestMethodIfNecessary(MethodManager $method, ArrayCollection $appendTo)
    {
        if ($method instanceof MethodForPropertyManager) {
            $testMethod = new TestMethodManager();
            $testMethod->setMethod($method);
            $appendTo->add($testMethod);
        }
    }

    /**
     * Deserialize JSON data to class manager
     *
     * @param string $jsonClassToDeserialize
     * @return ClassManager
     */
    protected function deserializeJsonDataToClassManager($jsonClassToDeserialize)
    {
        return $this->getSerializer()->deserialize($jsonClassToDeserialize, ClassManager::class, 'json');
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

    /**
     * @param mixed $classConfig
     * @return ClassConfig
     */
    private function getDefaultClassConfigIfNeed($classConfig)
    {
        if (false === ($classConfig instanceof ClassConfig)) {
            $classConfig = new ClassConfig();
        }

        return $classConfig;
    }
}
