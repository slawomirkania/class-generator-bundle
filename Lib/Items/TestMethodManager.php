<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\MethodInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TestMethodManager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TestMethodManager implements RenderableInterface, MethodInterface
{

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
     * Return common element template
     *
     * @return string
     */
    public function getTemplate()
    {

        return ""
            ."/**\n"
            ." * @covers <class>::<method_name>\n"
            ." */\n"
            ."public function <test_method_name>()\n"
            ."{\n"
            ."    \$this->markTestIncomplete(\n"
            ."        'This test has not been implemented yet.'\n"
            ."    );\n"
            ."}\n";
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
