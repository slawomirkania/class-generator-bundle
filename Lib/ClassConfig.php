<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

/**
 * Class config, additional parameters
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassConfig
{

    /**
     * @var boolean
     */
    private $noInterface = false;

    /**
     * @var boolean
     */
    private $noPHPUnitClass = false;

    /**
     * @return boolean
     */
    public function isNoInterface()
    {
        return $this->noInterface;
    }

    /**
     * @return boolean
     */
    public function isNoPHPUnitClass()
    {
        return $this->noPHPUnitClass;
    }

    /**
     * @param boolean $noInterface
     */
    public function setNoInterface($noInterface)
    {
        $this->noInterface = $noInterface;
    }

    /**
     * @param boolean $noPHPUnitClass
     */
    public function setNoPHPUnitClass($noPHPUnitClass)
    {
        $this->noPHPUnitClass = $noPHPUnitClass;
    }
}
