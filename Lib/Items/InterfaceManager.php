<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface;
use SimpleEntityGeneratorBundle\Lib\Tools;
use Symfony\Component\Validator\Constraints as Assert;
use SimpleEntityGeneratorBundle\Lib\Traits\TemplateTrait;

/**
 * Class Interface Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class InterfaceManager implements RenderableInterface, DumpableInterface, StructureWithMethodsInterface
{
    use TemplateTrait;

    /**
     * @Assert\NotNull(message = "Interface has to know about class!")
     * @Assert\Valid()
     */
    private $classManager = null;

    /**
     * @var ArrayCollection
     * @Assert\NotNull(message = "Interface methods collection can not be emtpy")
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
     * @Assert\IsTrue(message = "Invalid interface namespace, check yaml schema! eg. \AppBundle\Location\Entity")
     * @return boolean
     */
    public function isValidNamespace()
    {
        return Tools::isNamespaceValid($this->getNamespace());
    }

    /**
     * @return ClassManager
     */
    public function getClassManager()
    {
        return $this->classManager;
    }

    /**
     * @param ClassManager $classManager
     * @return InterfaceManager
     */
    public function setClassManager(ClassManager $classManager)
    {
        $this->classManager = $classManager;
        return $this;
    }

    /**
     * Return namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return sprintf("%s%s", $this->getClassManager()->getNamespace(), "Interface");
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
     * Return comment for interface
     *
     * @return string
     */
    public function getComment()
    {
        return sprintf("Interface for entity : %s", $this->getClassManager()->getNamespace());
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
     * Return namespace without name - for createing directory
     *
     * @return string
     * @throws Exception
     */
    public function getDirectory()
    {
        return Tools::getDirectoryFromNamespace($this->getNamespace());
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
            self::TAG_METHODS,
        ];
    }
}
