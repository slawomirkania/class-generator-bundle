<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Tools;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Traits\TemplateTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Decorator for Class Manager to generate Test Class
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestClassManager implements RenderableInterface, DumpableInterface, StructureWithMethodsInterface
{

    use TemplateTrait;

    /**
     * @Assert\NotNull(message="Test class has to know about class for testing")
     * @Assert\Valid()
     * @var ClassManager
     */
    private $classManager = null;

    /**
     * @var ArrayCollection
     * @Assert\NotNull(message="Method collection can not be empty!")
     * @Assert\Valid()
     */
    private $methods = null;

    /**
     * Construct
     *
     * @param ClassManager $classManager
     */
    public function __construct(ClassManager $classManager)
    {
        $this->setClassManager($classManager);
        $this->setMethods(new ArrayCollection());
    }

    /**
     * Get Base ClassManager
     *
     * @return ClassManager
     */
    public function getClassManager()
    {
        return $this->classManager;
    }

    /**
     * Set Base ClassManager
     *
     * @param ClassManager $classManager
     */
    public function setClassManager(ClassManager $classManager)
    {
        $this->classManager = $classManager;
    }

    /**
     * Return collection of methods
     *
     * @return ArrayCollection
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Set collection of methods
     *
     * @param ArrayCollection $methods
     * @return InterfaceManager
     */
    public function setMethods(ArrayCollection $methods)
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * Return comment for class/interface
     *
     * @return string
     */
    public function getComment()
    {
        return sprintf("Test for %s", $this->getClassManager()->getNamespace());
    }

    /**
     * Return namespace without name - for createing directory
     *
     * @return string
     * @throws Exception
     */
    public function getDirectory()
    {
        return str_replace("\\", "/", $this->getNamespaceWithoutName());
    }

    /**
     * Return name of class/interface from namespace
     *
     * @return string
     * @throws Exception
     */
    public function getName()
    {
        return $this->getClassManager()->getName()."Test";
    }

    /**
     * Return namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->appendTestDirectory(sprintf("%s\%s", $this->getClassManager()->getNamespaceWithoutName(), $this->getName()));
    }

    /**
     * Return namespace without name - for rendering namespace in class
     *
     * @return string
     * @throws Exception
     */
    public function getNamespaceWithoutName()
    {
        return $this->appendTestDirectory($this->getClassManager()->getNamespaceWithoutName());
    }

    /**
     * Return namespace without name - for rendering namespace in class
     *
     * @return string
     * @throws Exception
     */
    public function getNamespaceWithoutNameAndBackslashPrefix()
    {
        return Tools::removeBackslashPrefixFromNamespace(Tools::getNamespaceWithoutName($this->getNamespace()));
    }

    /**
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags()
    {
        return [
            self::TAG_NAMESPACE,
            self::TAG_COMMENT,
            self::TAG_NAME,
            self::TAG_CLASS,
            self::TAG_METHODS,
            self::TAG_TEST_OBJECT_TYPE,
            self::TAG_METHOD_BODY,
        ];
    }

    /**
     * Append \Test\ part to namespace
     *
     * @param string $namespace
     * @return string
     * @throws Exception
     */
    protected function appendTestDirectory($namespace)
    {
        if (false == Tools::isNamespaceValid($namespace)) {
            throw new Exception(sprintf("Invalid namespace: %s", $namespace));
        }

        $namespace = Tools::removeBackslashPrefixFromNamespace($namespace);
        $namespaceParts = explode("\\", $namespace);
        $firstParts = array_slice($namespaceParts, 0, 1);
        $secondParts = array_slice($namespaceParts, 1, count($namespaceParts) - 1);

        $newNamespaceParts = [];
        $newNamespaceParts = array_merge($newNamespaceParts, $firstParts);
        $newNamespaceParts[] = "Tests";
        $newNamespaceParts = array_merge($newNamespaceParts, $secondParts);

        return "\\".implode("\\", $newNamespaceParts);
    }
}
