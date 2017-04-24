<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface;
use SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use SimpleEntityGeneratorBundle\Lib\Traits\TemplateTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TestMethodManager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestMethodManager implements RenderableInterface, MethodInterface
{

    use TemplateTrait;

    /**
     * @Assert\NotNull(message="Method for test can not be empty!")
     * @Assert\Valid()
     * @var MethodManager
     */
    private $method = null;

    /**
     * Retrun Method Manager
     *
     * @return MethodManager
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set Method Manager
     *
     * @param MethodManager $method
     */
    public function setMethod(MethodManager $method)
    {
        $this->method = $method;
    }

    /**
     * Return prepared test method name
     */
    public function getPreparedName()
    {
        return sprintf("test%s", ucfirst($this->getMethod()->getPreparedName()));
    }

    /**
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags()
    {
        return [
            self::TAG_CLASS,
            self::TAG_METHOD_NAME,
            self::TAG_TEST_METHOD_NAME,
        ];
    }
}
