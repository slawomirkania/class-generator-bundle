<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Tools;

/**
 * Setter Method Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodSetterManager extends MethodManager implements SetterMethodInterface
{

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName()
    {
        return sprintf("set%s", parent::getPreparedName());
    }

    /**
     * If type is callable object or in namespace then can render type hinting in setter
     * @todo refactor
     *
     * @return boolean
     */
    public function canAddTypeHinting()
    {
        return Tools::isNamespaceValid($this->getProperty()->getType(), false) || class_exists($this->getProperty()->getTypeName());
    }
    
    /**
     * Return set of tags used in template
     *
     * @return array
     */
    public function getTemplateTags()
    {
        return [
            self::TAG_COMMENT,
            self::TAG_PROPERTY_TYPE,
            self::TAG_TYPE_HINTING,
            self::TAG_METHOD_NAME,
            self::TAG_PROPERTY_NAME,
            self::TAG_OPTIONAL_PART,
        ];
    }
}
