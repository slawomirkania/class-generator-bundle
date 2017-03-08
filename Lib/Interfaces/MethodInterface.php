<?php

namespace SimpleEntityGeneratorBundle\Lib\Interfaces;

/**
 * Interface for methods
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface MethodInterface
{

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName();
}
