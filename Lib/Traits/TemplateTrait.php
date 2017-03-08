<?php

namespace SimpleEntityGeneratorBundle\Lib\Traits;

use JMS\Serializer\Annotation\Type;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
trait TemplateTrait
{

    /**
     * @var string
     */
    private $template;

    /**
     * @Type("string")
     * @var string
     */
    private $templatePath;

    /**
     * @param string $template
     * @return this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Return common element template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     * @return string
     */
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;
        return $this;
    }
}
