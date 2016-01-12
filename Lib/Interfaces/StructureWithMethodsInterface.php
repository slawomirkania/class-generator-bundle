<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface for structures with methods: class, interace etc.
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
interface StructureWithMethodsInterface
{

    /**
     * Return collection of methods
     *
     * @return ArrayCollection
     */
    public function getMethods();

    /**
     * Set collection of methods
     *
     * @param ArrayCollection $methods
     * @return InterfaceManager
     */
    public function setMethods(ArrayCollection $methods);
}
