<?php

namespace SimpleEntityGeneratorBundle\Lib\Interfaces;

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
    const TAG_EXTENDS = '<extends>';
    const TAG_MULTILINE_COMMENT = '<multiline_comment>';
    const TAG_TEST_OBJECT_TYPE = '<test_object_type>';
    const TAG_METHOD_BODY = '<method_body>';
    const TAG_OPTIONAL_PART = '<optional_part>';

    /**
     * Set element template
     *
     * @param string $template
     */
    public function setTemplate($template);

    /**
     * Return common element template
     *
     * @return string
     */
    public function getTemplate();

    /**
     * Return element template Path
     *
     * @return string
     */
    public function getTemplatePath();

    /**
     * Return element template Path
     *
     * @param string $templatePath
     */
    public function setTemplatePath($templatePath);

    /**
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags();
}
