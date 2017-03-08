<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Interfaces\SetterMethodInterface;

/**
 * Setter Method for Interface Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodSetterInterfaceManager extends MethodManager implements SetterMethodInterface
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
     *
     * @return boolean
     */
    public function canAddTypeHinting()
    {
        return $this->getProperty()->isObjectType();
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
