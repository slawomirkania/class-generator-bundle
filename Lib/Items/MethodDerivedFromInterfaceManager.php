<?php

namespace SimpleEntityGeneratorBundle\Lib\Items;

class MethodDerivedFromInterfaceManager extends MethodManager
{
    private $preparedName;

    public function __construct(ClassManager $classManager, $preparedName)
    {
        parent::__construct($classManager);
        $this->preparedName = $preparedName;
    }

    /**
     * Return prepared method name from property eg. getNameOrSurname
     *
     * @return string
     */
    public function getPreparedName()
    {
        return $this->preparedName;
    }

    public function getTemplateTags()
    {
        return [
            self::TAG_METHOD_NAME,
        ];
    }
}
