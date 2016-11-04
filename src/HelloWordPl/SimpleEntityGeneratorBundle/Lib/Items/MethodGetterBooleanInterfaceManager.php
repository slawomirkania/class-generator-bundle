<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

/**
 * Getter Method Boolean Manager For Interface
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class MethodGetterBooleanInterfaceManager extends MethodManager
{

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName()
    {
        return sprintf("is%s", parent::getPreparedName());
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
            self::TAG_METHOD_NAME,
        ];
    }
}
