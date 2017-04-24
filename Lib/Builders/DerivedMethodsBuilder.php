<?php

namespace SimpleEntityGeneratorBundle\Lib\Builders;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Lib\Items\MethodDerivedFromInterfaceManager;

class DerivedMethodsBuilder
{
    private $interfaceNamespace;

    private $classManager;

    private $methodsToSkip = [];

    /**
     * @param $interfaceNamespace
     * @param $classManager
     */
    public function __construct($interfaceNamespace, ClassManager $classManager)
    {
        if (!$interfaceNamespace) {
            throw new \InvalidArgumentException("Interface namespace cannot be empty");
        }
        if (!interface_exists($interfaceNamespace)) {
            throw new \RuntimeException(sprintf("%s could not be loaded", $interfaceNamespace));
        }
        $this->interfaceNamespace = $interfaceNamespace;
        $this->classManager = $classManager;
    }

    public function getMethodsDerivedFromInterface()
    {
        $result = new ArrayCollection();
        $interfaceMethods = $this->resolveInterfaceMethods();
        foreach ($interfaceMethods as $interfaceMethod) {
            $methodName = $interfaceMethod->getName();
            if (in_array($methodName, $this->methodsToSkip)) {
                continue;
            }
            $methodManager = new MethodDerivedFromInterfaceManager($this->classManager, $methodName);
            $result->add($methodManager);
        }
        return $result;
    }

    public function setMethodsToSkip(array $methodsNames)
    {
        $this->methodsToSkip = $methodsNames;
    }

    /**
     * @return \ReflectionMethod[]
     */
    protected function resolveInterfaceMethods()
    {
        $reflection = new \ReflectionClass($this->interfaceNamespace);
        return $reflection->getMethods();
    }
}