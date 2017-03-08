<?php

namespace SimpleEntityGeneratorBundle\Lib\Interfaces;

/**
 * Interface for items which are able to dump to files
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface DumpableInterface
{

    /**
     * Return name of class/interface from namespace
     *
     * @return string
     * @throws Exception
     */
    public function getName();

    /**
     * Return namespace without name - for rendering namespace in class
     *
     * @return string
     * @throws Exception
     */
    public function getNamespaceWithoutName();

    /**
     * Return namespace
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Return namespace without name - for createing directory
     *
     * @return string
     * @throws Exception
     */
    public function getDirectory();

    /**
     * Return comment for class/interface
     *
     * @return string
     */
    public function getComment();

    /**
     * Return namespace without name - for rendering namespace in class
     *
     * @return string
     * @throws Exception
     */
    public function getNamespaceWithoutNameAndBackslashPrefix();
}
