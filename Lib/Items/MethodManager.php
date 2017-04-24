<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface;
use SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use Symfony\Component\Validator\Constraints as Assert;
use SimpleEntityGeneratorBundle\Lib\Traits\TemplateTrait;

/**
 * Method Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
abstract class MethodManager implements RenderableInterface, MethodInterface
{
    use TemplateTrait;

    /**
     * @Assert\NotNull(message="Method has to know about class!")
     * @Assert\Valid()
     * @var ClassManager
     */
    private $classManager = null;

    /**
     * Construct.
     *
     * @param ClassManager $classManager
     */
    public function __construct(ClassManager $classManager)
    {
        $this->setClassManager($classManager);
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
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags()
    {
        // to override
        return [];
    }
}
