<?php

namespace SimpleEntityGeneratorBundle\Lib;

use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class config, additional parameters
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ClassConfig
{

    /**
     * @var boolean
     * @Type("boolean")
     * @Assert\Type("boolean")
     * @SerializedName("no_interface")
     */
    private $noInterface = false;

    /**
     * @var boolean
     * @Type("boolean")
     * @Assert\Type("boolean")
     * @SerializedName("no_phpunit_class")
     */
    private $noPHPUnitClass = false;

    /**
     * @param boolean $noInterface
     * @param boolean $noPHPUnitClass
     */
    public function __construct($noInterface = false, $noPHPUnitClass = false)
    {
        $this->noInterface = $noInterface;
        $this->noPHPUnitClass = $noPHPUnitClass;
    }

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
