<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Manager for Class constructor
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassConstructorManager implements RenderableInterface
{

    /**
     * Constructor for this class
     *
     * @Assert\NotNull(message="Constructor has to know about class!")
     * @Assert\Valid()
     * @var ClassManager
     */
    private $classManager = null;

    /**
     * Init Properties for constructor
     *
     * @Assert\NotNull(message="InitProperties can not be null!")
     * @Assert\Valid()
     * @var ArrayCollection
     */
    private $initProperties = null;

    /**
     * Constructor
     *
     * @param ClassManager $classManager
     */
    public function __construct(ClassManager $classManager)
    {
        $this->setInitProperties(new ArrayCollection());
        $this->setClassManager($classManager);
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
     */
    public function setClassManager(ClassManager $classManager)
    {
        $this->classManager = $classManager;
    }

    /**
     * @return ArrayCollection
     */
    public function getInitProperties()
    {
        return $this->initProperties;
    }

    /**
     * @param ClassManager $initProperties
     */
    public function setInitProperties(ArrayCollection $initProperties)
    {
        $this->initProperties = $initProperties;
    }

    /**
     * Return common element template
     *
     * @return string
     */
    public function getTemplate()
    {
        return ""
            ."/**\n"
            ." * Constructor.\n"
            ." */\n"
            ."public function __constructor()\n"
            ."{\n"
            ."<init_properties>"
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
            self::TAG_INIT_PROPERTIES,
        ];
    }
}
