<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Exceptions\StructureResolverException;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Renderer;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Tools;
use ReflectionClass;
use UnrecognizedItemToDumpException;
use ReflectionMethod;

/**
 * Resolve Classes content elements
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class StructureResolver
{

    /**
     * @param string $content
     * @param DumpableInterface $item
     * @param ReflectionClass $reflectionClass
     * @return string
     * @throws UnrecognizedItemToDumpException
     */
    public function getUpdatedItemSourceContent($content, DumpableInterface $item, ReflectionClass $reflectionClass)
    {
        switch (true) {
            case $item instanceof ClassManager:
                return $this->getUpdatedClassContent($content, $item, $reflectionClass);
            case $item instanceof InterfaceManager:
                return $this->getUpdatedInterfaceContent($content, $item, $reflectionClass);
            case $item instanceof TestClassManager:
                return $this->getUpdatedTestClassContent($content, $item, $reflectionClass);
            default:
                throw $this->getExceptionUnrecognizedItem($item);
        }
    }

    /**
     * @param string $content
     * @param TestClassManager $item
     * @param ReflectionClass $reflectionClass
     * @return string
     */
    protected function getUpdatedTestClassContent($content, TestClassManager $item, ReflectionClass $reflectionClass)
    {
        $item->setMethods($this->resolveMethodsToRender($item, $reflectionClass));
        return $this->getRenderer()->renderAndPutItemsToContent($content, $item->getMethods(), $this->getNewMethodPostion($reflectionClass));
    }

    /**
     * @param string $content
     * @param ClassManager $item
     * @param ReflectionClass $reflectionClass
     * @return string
     */
    protected function getUpdatedClassContent($content, ClassManager $item, ReflectionClass $reflectionClass)
    {
        $this->resolveClassContent($content, $item, $reflectionClass);
        $updatedContent = $this->getRenderer()->renderAndPutItemsToContent($content, $item->getMethods(), $this->getNewMethodPostion($reflectionClass));
        $updatedContent = $this->getRenderer()->renderAndPutConstructorBodyToContent($updatedContent, $item->getConstructor(), $this->getNewInitPropertyPosition($reflectionClass));
        $updatedContent = $this->getRenderer()->renderAndPutItemsToContent($updatedContent, $item->getProperties(), $this->getNewPropertyPosition($reflectionClass));
        return $updatedContent;
    }

    /**
     * @param string $content
     * @param InterfaceManager $item
     * @param ReflectionClass $reflectionClass
     * @return string
     */
    protected function getUpdatedInterfaceContent($content, InterfaceManager $item, ReflectionClass $reflectionClass)
    {
        $this->resolveInterfaceContent($item, $reflectionClass);
        $updatedContent = $this->getRenderer()->renderAndPutItemsToContent($content, $item->getMethods(), $this->getNewMethodPostion($reflectionClass));
        return $updatedContent;
    }

    /**
     * @param string $content
     * @param ClassManager $item
     * @param ReflectionClass $reflectionClass
     * @return ClassManager
     */
    protected function resolveClassContent($content, ClassManager $item, ReflectionClass $reflectionClass)
    {
        $item->setConstructor($this->resolveConstructorToRender($content, $item, $reflectionClass));
        $item->setProperties($this->resolvePropertiesToRender($item, $reflectionClass));
        $item->setMethods($this->resolveMethodsToRender($item, $reflectionClass));
        return $item;
    }

    /**
     * @param InterfaceManager $item
     * @param ReflectionClass $reflectionClass
     * @return InterfaceManager
     */
    protected function resolveInterfaceContent(InterfaceManager $item, ReflectionClass $reflectionClass)
    {
        $item->setMethods($this->resolveMethodsToRender($item, $reflectionClass));
        return $item;
    }

    /**
     * Get properties to render in item file
     *
     * @param ClassManager $item
     * @param ReflectionClass $reflectionClass
     * @return ArrayCollection
     */
    protected function resolvePropertiesToRender(ClassManager $item, ReflectionClass $reflectionClass)
    {
        $propertiesToRender = new ArrayCollection();
        foreach ($item->getProperties() as $itemProperty) {
            $found = false;
            foreach ($reflectionClass->getProperties() as $reflectionProperty) {
                if ($itemProperty->getPreparedName() == $reflectionProperty->name) {
                    $found = true;
                    break;
                }
            }
            if (false == $found) {
                $propertiesToRender->add($itemProperty);
            }
        }

        return $propertiesToRender;
    }

    /**
     * Get methods to render in item file
     *
     * @param StructureWithMethodsInterface $item
     * @param ReflectionClass $reflectionClass
     * @return ArrayCollection
     * @throws Exception
     */
    protected function resolveMethodsToRender(StructureWithMethodsInterface $item, ReflectionClass $reflectionClass)
    {
        $methodsToRender = new ArrayCollection();
        foreach ($item->getMethods() as $itemMethod) {
            if (false == ($itemMethod instanceof MethodInterface)) {
                throw new StructureResolverException(sprintf("Item %s does not implement Method Interface", get_class($itemMethod)));
            }

            $found = false;
            foreach ($reflectionClass->getMethods() as $reflectionMethod) {
                if ($itemMethod->getPreparedName() == $reflectionMethod->name) {
                    $found = true;
                    break;
                }
            }
            if (false == $found) {
                $methodsToRender->add($itemMethod);
            }
        }

        return $methodsToRender;
    }

    /**
     * @param string $content
     * @param ClassManager $item
     * @param ReflectionClass $reflectionClass
     * @return ClassConstructorManager
     */
    protected function resolveConstructorToRender($content, ClassManager $item, ReflectionClass $reflectionClass)
    {
        $constructor = $item->getConstructor();
        $constructorFromFile = $reflectionClass->getConstructor();
        $source = Tools::explodeTemplateStringToArray($content);

        $constructorBody = implode("", array_slice($source, $constructorFromFile->getStartLine(), $constructorFromFile->getEndLine() - $constructorFromFile->getStartLine()));

        $matches = [];
        preg_match_all("/this->[\S]+/", $constructorBody, $matches);

        $initPropertiesFromConstructor = [];
        if (count($matches) > 0) {
            foreach ($matches[0] as $match) {
                $initPropertiesFromConstructor[] = str_replace("this->", "", trim($match));
            }
        }

        $newInitProperties = new ArrayCollection();
        foreach ($constructor->getInitProperties() as $initProperty) {
            if (in_array($initProperty->getProperty()->getPreparedName(), $initPropertiesFromConstructor)) {
                continue;
            }

            $newInitProperties->add($initProperty);
        }

        $constructor->setInitProperties($newInitProperties);
        $item->setConstructor($constructor);

        return $constructor;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return integer
     */
    protected function getNewMethodPostion(ReflectionClass $reflectionClass)
    {
        return $reflectionClass->getEndLine() - 1;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return type
     */
    protected function getNewInitPropertyPosition(ReflectionClass $reflectionClass)
    {
        $constructor = $reflectionClass->getConstructor();

        if ($constructor instanceof ReflectionMethod) {
            return $constructor->getEndLine() - 1;
        }

        return $reflectionClass->getEndLine() - 1;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return type
     */
    protected function getNewPropertyPosition(ReflectionClass $reflectionClass)
    {
        $constructor = $reflectionClass->getConstructor();
        if ($constructor instanceof ReflectionMethod) {
            $commentParts = Tools::explodeTemplateStringToArray($constructor->getDocComment());
            return ($constructor->getStartLine() - count($commentParts)) - 1;
        }

        $methods = $reflectionClass->getMethods();

        if (count($methods) > 0) {
            $firstMethod = reset($methods);
            if ($firstMethod instanceof ReflectionMethod) {
                return $firstMethod->getStartLine() - 1;
            }
        }

        return $reflectionClass->getEndLine() - 1;
    }

    /**
     * @return Renderer
     */
    protected function getRenderer()
    {
        return new Renderer();
    }

    /**
     * @param mixed $item
     * @return UnrecognizedItemToDumpException
     */
    protected function getExceptionUnrecognizedItem($item)
    {
        return new UnrecognizedItemToDumpException(sprintf("Unrecognized item class: %s", get_class($item)));
    }
}
