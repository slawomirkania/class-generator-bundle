<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MultilineCommentableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Tools;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Traits\MultilineCommentTrait;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Manager of Class structure
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassManager implements RenderableInterface, DumpableInterface, StructureWithMethodsInterface, MultilineCommentableInterface
{
    use MultilineCommentTrait;

    /**
     * Collection of MethodManager
     *
     * @var ArrayCollection
     * @Assert\NotNull(message="Properties Collection can not be empty!")
     * @Assert\Valid()
     */
    private $methods = null;

    /**
     * Collection of PropertyManager
     *
     * @Type("Doctrine\Common\Collections\ArrayCollection<HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager>")
     * @Assert\NotNull(message="Properties Collection can not be empty!")
     * @Assert\Valid()
     */
    private $properties = null;

    /**
     * Interface namespace
     *
     * @var InterfaceManager
     * @Assert\Valid()
     */
    private $interface = null;

    /**
     * Class constructor
     *
     * @var ClassConstructorManager
     * @Assert\NotNull(message="Constructor can not be null!")
     * @Assert\Valid()
     */
    private $constructor = null;

    /**
     * Test Class
     *
     * @var TestClassManager
     * @Assert\Valid()
     * @var TestClassManager
     */
    private $testClass = null;

    /**
     * namespace of class - class name is retrieved from namespace
     *
     * @Type("string")
     * @Assert\NotBlank(message="Namespace can not be blank!")
     */
    private $namespace = "";

    /**
     * Comment under class
     *
     * @Type("string")
     */
    private $comment = "";

    /**
     * Base class namespace
     *
     * @Type("string")
     */
    private $extends = "";

    /**
     * Construct
     */
    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->methods = new ArrayCollection();
    }

    /**
     * @Assert\IsTrue(message = "Duplicated properties names in entity, check yaml schema!")
     * @return boolean
     */
    public function hasUniquePropertiesNames()
    {
        $tmpPropertiesNames = [];
        foreach ($this->getProperties() as $property) {
            /* @var $property PropertyManager */
            $propertyName = $property->getName();
            if (in_array($propertyName, $tmpPropertiesNames)) {
                return false;
            }

            $tmpPropertiesNames[] = $propertyName;
        }

        return true;
    }

    /**
     * @Assert\IsTrue(message = "Invalid class namespace, check yaml schema! eg. \AppBundle\Vendor\Entity")
     * @return boolean
     */
    public function isValidNamespace()
    {
        return Tools::isNamespaceValid($this->getNamespace());
    }

    /**
     * @Assert\IsTrue(message = "Invalid base class namespace, check yaml schema! eg. \AppBundle\Vendor\Entity")
     * @return boolean
     */
    public function isValidExtends()
    {
        if (false == $this->hasExtends()) {
            return true;
        }

        if (false == Tools::isFirstCharBackslash($this->getExtends())) {
            return false;
        }

        if (class_exists($this->getExtends())) {
            return true;
        }

        return Tools::isNamespaceValid($this->getNamespace());
    }

    /**
     * @return ArrayCollection
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param ArrayCollection $methods
     * @return InterfaceManager
     */
    public function setMethods(ArrayCollection $methods)
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param ArrayCollection $properties
     * @return ClassManager
     */
    public function setProperties(ArrayCollection $properties)
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * @return InterfaceManager
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * @param InterfaceManager $interface
     * @return ClassManager
     */
    public function setInterface(InterfaceManager $interface)
    {
        $this->interface = $interface;
        return $this;
    }

    /**
     * @return ClassConstructorManager
     */
    public function getConstructor()
    {
        return $this->constructor;
    }

    /**
     * @param ClassConstructorManager $constructor
     * @return ClassManager
     */
    public function setConstructor(ClassConstructorManager $constructor)
    {
        $this->constructor = $constructor;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string
     * @return ClassManager
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return TestClassManager
     */
    public function getTestClass()
    {
        return $this->testClass;
    }

    /**
     * @param TestClassManager $testClass
     * @return ClassManager
     */
    public function setTestClass(TestClassManager $testClass)
    {
        $this->testClass = $testClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     * @return ClassManager
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Return base class namespace
     *
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * Set base class namespace
     *
     * @param string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    /**
     * has set base class namespace
     *
     * @return boolean
     */
    public function hasExtends()
    {
        return false == empty($this->getExtends());
    }

    /**
     * Check interface exists
     *
     * @return boolean
     */
    public function hasInterface()
    {
        return $this->getInterface() instanceof InterfaceManager;
    }

    /**
     * Check interface exists
     *
     * @return boolean
     */
    public function hasTestClass()
    {
        return $this->getTestClass() instanceof TestClassManager;
    }

    /**
     * Return namespace without name - for createing directory
     *
     * @return string
     */
    public function getDirectory()
    {
        return Tools::getDirectoryFromNamespace($this->getNamespace());
    }

    /**
     * Return name of class/interface from namespace
     *
     * @return string
     * @throws Exception
     */
    public function getName()
    {
        return Tools::getNameFromNamespace($this->getNamespace());
    }

    /**
     * Return namespace without name - for rendering namespace in class
     *
     * @return string
     * @throws Exception
     */
    public function getNamespaceWithoutName()
    {
        return Tools::getNamespaceWithoutName($this->getNamespace());
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
     * Return common element template
     *
     * @return string
     */
    public function getTemplate()
    {
        return ""
            ."<?php\n"
            ."\n"
            ."namespace <namespace>;\n"
            ."\n"
            ."/**\n"
            ." *<comment><multiline_comment>\n"
            ." */\n"
            ."class <name><extends><interface>\n"
            ."{\n"
            ."\n"
            ."<properties>"
            ."\n"
            ."<constructor>"
            ."\n"
            ."<methods>"
            ."\n"
            ."}";
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
            self::TAG_EXTENDS,
            self::TAG_INTERFACE,
            self::TAG_CONSTRUCTOR,
            self::TAG_PROPERTIES,
            self::TAG_METHODS,
            self::TAG_MULTILINE_COMMENT,
        ];
    }
}
