<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces;

/**
 * Interface for renderable Items
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface RenderableInterface
{

    /**
     * Tags for templates
     *
     * @var string
     */
    const TAG_INTERFACE = '<interface>';
    const TAG_PROPERTIES = '<properties>';
    const TAG_NAMESPACE = '<namespace>';
    const TAG_COMMENT = '<comment>';
    const TAG_NAME = '<name>';
    const TAG_METHODS = '<methods>';
    const TAG_TYPE = '<type>';
    const TAG_CONSTRAINTS = '<constraints>';
    const TAG_PROPERTY_TYPE = '<property_type>';
    const TAG_TYPE_HINTING = '<type_hinting>';
    const TAG_METHOD_NAME = '<method_name>';
    const TAG_PROPERTY_NAME = '<property_name>';
    const TAG_CLASS = '<class>';
    const TAG_CONSTRUCTOR = '<constructor>';
    const TAG_INIT_PROPERTIES = '<init_properties>';
    const TAG_TEST_METHOD_NAME = '<test_method_name>';
    const TAG_JMS_PART = '<jms_part>';

    /**
     * Return common element template
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags();
}
