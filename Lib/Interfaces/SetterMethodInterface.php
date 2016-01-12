<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces;

/**
 * Interface for setter methods
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface SetterMethodInterface extends MethodInterface
{

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName();

    /**
     * If type is callable object or in namespace then can render type hinting in setter
     *
     * @return boolean
     */
    public function canAddTypeHinting();
}
