<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

use Exception;
use JMS\Serializer\TypeParser;

/**
 * Tools
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class Tools
{

    /**
     * @param string $namespace
     * @param string $mandatoryFirstBackslash
     * @return boolean
     */
    public static function isNamespaceValid($namespace, $mandatoryFirstBackslash = true)
    {
        if ($mandatoryFirstBackslash && false == self::isFirstCharBackslash($namespace)) {
            return false;
        }

        if (1 !== preg_match("/[\\\\]{1,1}/", $namespace)) {
            return false;
        }

        if (1 === preg_match("/[\\\\]{2,}/", $namespace)) {
            return false;
        }

        if (1 === preg_match('/[^a-zA-Z0-9\\\\\\_]+/', $namespace)) {
            return false;
        }

        $namespaceElementsArray = explode("\\", $namespace);
        if (count($namespaceElementsArray) < 3) {
            return false;
        }

        foreach ($namespaceElementsArray as $element) {
            if (ctype_digit(substr($element, 0, 1))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public static function isValidPropertyNameString($name)
    {
        if (false == is_string($name)) {
            return false;
        }

        if (empty($name)) {
            return false;
        }

        if ("_" == $name) {
            return false;
        }

        if (1 === preg_match('/[^a-zA-Z0-9\_]+/', $name)) {
            return false;
        }

        if (ctype_digit(substr($name, 0, 1))) {
            return false;
        }

        return true;
    }

    /**
     * @param string $type
     * @return boolean
     */
    public static function isValidPropertyTypeString($type)
    {
        if (false == is_string($type)) {
            return false;
        }

        try {
            $jmsTypeParser = new TypeParser();
            $jmsTypeParser->parse($type);
        } catch (Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * @param string $namespace
     * @return string
     * @throws Exception
     */
    public static function getNamespaceWithoutName($namespace)
    {
        self::checkNamespaceValid($namespace);
        $parts = explode('\\', $namespace);
        unset($parts[count($parts) - 1]);
        return implode("\\", $parts);
    }

    /**
     * @param string $namespace
     * @return string
     * @throws Exception
     */
    public static function getDirectoryFromNamespace($namespace)
    {
        self::checkNamespaceValid($namespace);
        return str_replace("\\", "/", self::getNamespaceWithoutName($namespace));
    }

    /**
     * @param string $namespace
     * @return string
     * @throws Exception
     */
    public static function getNameFromNamespace($namespace)
    {
        self::checkNamespaceValid($namespace);
        $parts = explode('\\', $namespace);
        return $parts[count($parts) - 1];
    }

    /**
     * @param string $namespace
     * @return string
     */
    public static function removeBackslashPrefixFromNamespace($namespace)
    {
        self::checkNamespaceValid($namespace);
        if ("\\" == substr($namespace, 0, 1)) {
            return substr($namespace, 1);
        }
        return $namespace;
    }

    /**
     * Throw Exception when namespace invalid
     *
     * @param string $namespace
     * @throws Exception
     */
    public static function checkNamespaceValid($namespace)
    {
        if (false == self::isNamespaceValid($namespace)) {
            throw new Exception(sprintf("Invalid namespace: %s", $namespace));
        }
    }

    /**
     * @param string $string
     * @return array
     * @throws Exception
     */
    public static function explodeTemplateStringToArray($string)
    {
        if (false == is_string($string)) {
            throw new Exception("Param has to be string!");
        }

        return preg_split("/\n/", $string);
    }

    /**
     * @param array $array
     * @return string
     * @throws Exception
     */
    public static function implodeArrayToTemplate($array)
    {
        if (false == is_array($array)) {
            throw new Exception("Invalid array!");
        }

        return implode("\n", $array);
    }

    /**
     * Check existance of constraint
     * proper annotation eg. @\Symfony\Component\Validator\Constraints\Valid()
     *
     * @param string $constraintAnnotation
     * @return boolean
     */
    public static function isCallableConstraintAnnotation($constraintAnnotation)
    {
        $output = [];
        preg_match("/\@(.*?)\(.*?\)/", $constraintAnnotation, $output);

        if ($output < 2) {
            return false;
        }
        if (false == class_exists(end($output))) {
            return false;
        }

        return true;
    }

    /**
     * If first character of string is backslash then return true
     *
     * @param string $string
     * @return boolean
     * @throws Exception
     */
    public static function isFirstCharBackslash($string)
    {
        if (false == is_string($string)) {
            throw new Exception("Invalid string!");
        }

        return "\\" == substr((string) $string, 0, 1);
    }
}
