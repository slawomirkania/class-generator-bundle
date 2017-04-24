<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

abstract class MethodForPropertyManager extends MethodManager
{
    /**
     * @Type("SimpleEntityGeneratorBundle\Lib\Items\PropertyManager")
     * @Assert\NotNull(message="Property for method can not be empty!")
     * @Assert\Valid()
     */
    private $property = null;

    /**
     * @return PropertyManager
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param PropertyManager $property
     * @return $this
     */
    public function setProperty(PropertyManager $property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName()
    {
        return ucfirst($this->getProperty()->getPreparedName());
    }
}