<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items;

use Doctrine\Common\Util\Inflector;
use Exception;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Tools;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\TypeParser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PropertyManager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class PropertyManager implements RenderableInterface
{

    /**
     * Property predefined types
     *
     * @var string
     */
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_ARRAY_COLLECTION = 'Doctrine\Common\Collections\ArrayCollection';

    /**
     * Comment of property
     *
     * @Type("string")
     */
    private $comment = '';

    /**
     * Collection of Validators
     *
     * @Type("Doctrine\Common\Collections\ArrayCollection<string>")
     */
    private $validators = null;

    /**
     * Property name
     *
     * @Type("string")
     * @Assert\NotBlank(message="Property name can not be empty!")
     */
    private $name = '';

    /**
     * Property type
     *
     * @Type("string")
     * @Assert\NotBlank(message="Property type can not be empty!")
     */
    private $type = '';

    /**
     * Constr.
     */
    public function __construct()
    {
        $this->validators = new ArrayCollection();
    }

    /**
     * @Assert\IsTrue(message = "Invalid property name!")
     * @return boolean
     */
    public function isValidName()
    {
        if (false == Tools::isValidPropertyNameString($this->getName())) {
            return false;
        }

        return true;
    }

    /**
     * @Assert\IsTrue(message = "Invalid property type!")
     * @return boolean
     */
    public function isValidType()
    {
        if (false == Tools::isValidPropertyTypeString($this->getType())) {
            return false;
        }

        return true;
    }

    /**
     * Check is property boolean type
     *
     * @return boolean
     */
    public function isTypeBoolean()
    {
        return PropertyManager::TYPE_BOOLEAN == $this->getType();
    }

    /**
     * Check is property ArrayCollection type
     *
     * @return boolean
     */
    public function isTypeArrayCollection()
    {
        return PropertyManager::TYPE_ARRAY_COLLECTION == $this->getTypeName();
    }

    /**
     * Return property comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set property comment
     *
     * @param string $comment
     * @return PropertyManager
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Return validators names array
     *
     * @return ArrayCollection
     */
    public function getValidators()
    {
        if (false == ($this->validators instanceof ArrayCollection)) {
            return new ArrayCollection();
        }

        return $this->validators;
    }

    /**
     * Set validators names array
     *
     * @param ArrayCollection $validators
     * @return PropertyManager
     */
    public function setValidators(ArrayCollection $validators)
    {
        $this->validators = $validators;
        return $this;
    }

    /**
     * Return property name string
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return prepared property name eg. name_and_surname => nameAndSurname
     *
     * @param string $propertyName
     * @return string
     */
    public function getPreparedName()
    {
        return Inflector::camelize($this->getName());
    }

    /**
     * Set property name
     *
     * @param string $name
     * @return PropertyManager
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Return property type string
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return only type name without params eg. Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post> result Doctrine\Common\Collections\ArrayCollection
     *
     * @return string
     * @throws Exception
     */
    public function getTypeName()
    {
        $typeParser = new TypeParser();
        $result = $typeParser->parse($this->getType());

        if (false == array_key_exists("name", $result)) {
            throw new Exception("Invalid type parsing result");
        }

        return $result["name"];
    }

    /**
     * Set property type
     *
     * @param string $type
     * @return PropertyManager
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Return common element template
     *
     * @return string
     */
    public function getTemplate()
    {
        return ""
            ."/**\n"
            ." * <comment>\n"
            ." *\n"
            ."<validators>"
            ." * @\JMS\Serializer\Annotation\Type(\"<type>\")\n"
            ." * @var <type>\n"
            ." */\n"
            ."private $<name>;\n";
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
            self::TAG_VALIDATORS,
            self::TAG_TYPE,
            self::TAG_NAME
        ];
    }
}
