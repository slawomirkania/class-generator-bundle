<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib;

use SimpleEntityGeneratorBundle\Lib\Tools;

/**
 * Tools Tests
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class ToolsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataForMethodRemoveBackslashPrefixFromNamespace
     */
    public function testRemoveBackslashPrefixFromNamespace($namespace, $output)
    {
        $this->assertEquals($output, Tools::removeBackslashPrefixFromNamespace($namespace));
    }

    public function dataForMethodRemoveBackslashPrefixFromNamespace()
    {
        return [
            ["\\GeneratorEntityBundle\\Controller\\ClassName", "GeneratorEntityBundle\\Controller\\ClassName"],
            ["\\GeneratorEntityBundle\\Controller\\Test\\ClassName", "GeneratorEntityBundle\\Controller\\Test\\ClassName"],
            ["\\GeneratorEntityBundle\\ClassName", "GeneratorEntityBundle\\ClassName"],
        ];
    }

    /**
     * @dataProvider dataForMethodGetNameFromNamespace
     */
    public function testGetNameFromNamespace($namespace, $output)
    {
        $this->assertEquals($output, Tools::getNameFromNamespace($namespace));
    }

    public function dataForMethodGetNameFromNamespace()
    {
        return [
            ["\\GeneratorEntityBundle\\Controller\\ClassName", "ClassName"],
            ["\\GeneratorEntityBundle\\Controller\\Test\\ClassName", "ClassName"],
            ["\\GeneratorEntityBundle\\ClassName", "ClassName"],
        ];
    }

    /**
     * @dataProvider dataForMethodGetDirectoryFromNamespace
     */
    public function testGetDirectoryFromNamespace($namespace, $output)
    {
        $this->assertEquals($output, Tools::getDirectoryFromNamespace($namespace));
    }

    public function dataForMethodGetDirectoryFromNamespace()
    {
        return [
            ["\\GeneratorEntityBundle\\Controller\\ClassName", "/GeneratorEntityBundle/Controller"],
            ["\\GeneratorEntityBundle\\Controller\\Test\\ClassName", "/GeneratorEntityBundle/Controller/Test"],
            ["\\GeneratorEntityBundle\\ClassName", "/GeneratorEntityBundle"],
        ];
    }

    /**
     * @dataProvider dataForMethodGetNamespaceWithoutName
     */
    public function testGetNamespaceWithoutName($namespace, $output)
    {
        $this->assertEquals($output, Tools::getNamespaceWithoutName($namespace));
    }

    public function dataForMethodGetNamespaceWithoutName()
    {
        return [
            ["\\GeneratorEntityBundle\\ClassName", "\\GeneratorEntityBundle"],
            ["\\GeneratorEntityBundle\\Controller\\ClassName", "\\GeneratorEntityBundle\\Controller"],
            ["\\GeneratorEntityBundle\\Controller\\Test\\ClassName", "\\GeneratorEntityBundle\\Controller\\Test"],
            ["\\GeneratorEntityBundle\\ClassName", "\\GeneratorEntityBundle"],
        ];
    }

    /**
     * @dataProvider dataForMethodIsNamespaceValidWhenTrue
     */
    public function testIsNamespaceValidWhenTrue($namespace)
    {
        $this->assertTrue(Tools::isNamespaceValid($namespace));
    }

    public function dataForMethodIsNamespaceValidWhenTrue()
    {
        return [
            ["\\GeneratorEntityBundle\\Controller\\Lib"],
            ["\\GeneratorEntityBundle1\\Controller\\Lib"],
            ["\\Generator1EntityBundle\\Controller\\Lib"],
            ["\\Generator1EntityBundle\\Controller1\\Lib1"],
            ["\\GeneratorEntityBundle\\Controller"],
            ["\\generator_entity_bundle\\controller"],
            ["\\generatorentitybundle\\controller"],
        ];
    }

    /**
     * @dataProvider dataForMethodIsNamespaceValidWhenFalse
     */
    public function testIsNamespaceValidWhenFalse($namespace)
    {
        $this->assertFalse(Tools::isNamespaceValid($namespace));
    }

    public function dataForMethodIsNamespaceValidWhenFalse()
    {
        return [
            ["\\GeneratorEntityBundle"],
            ["\\\\1GeneratorEntityBundle\\\\Controller\\\\Lib"],
            ["\\GeneratorEntityBundle\\1Controller\\Lib"],
            ["\\GeneratorEntityBundle\\Controller\\1Lib"],
            ["\\Generator!EntityBundle\\Controller"],
            ["\\Generator@EntityBundle\\Controller"],
            ["\\Generator#EntityBundle\\Controller"],
            ["\\Generator\$EntityBundle\\Controller"],
            ["\\Generator%EntityBundle\\Controller"],
            ["\\Generator^EntityBundle\\Controller"],
            ["\\Generator&EntityBundle\\Controller"],
            ["\\Generator*EntityBundle\\Controller"],
            ["\\Generator(EntityBundle\\Controller"],
            ["\\Generator)EntityBundle\\Controller"],
            ["\\Generator-EntityBundle\\Controller"],
            ["\\Generator=EntityBundle\\Controller"],
            ["\\GeneratorEntityBundle\\Cont&roller"],
            ["\\Generator EntityBundle\\Cont&roller"],
            ["\\GeneratorEntityBundle\\ Cont&roller"],
            ["\\Generator;EntityBundle\\Cont&roller"],
            ["\\GeneratorEntityBundle\\Cont&roller"],
            ["/GeneratorEntityBundle/Cont&roller"],
            ["\\GeneratorEntityBundle\\Cont%roller"],
            ["\\~GeneratorEntityBundle\\Cont%roller"],
            ["\\GeneratorEntityBundle\\\\Controller"],
            ["\\GeneratorEntityBundle>Controller"],
            ["\\GeneratorEntityBundle<Controller"],
            ["\\GeneratorEntityBundle?Controller"],
            ["\\GeneratorEntityBundle:Controller"],
            ["\\GeneratorEntityBundle;Controller"],
            ["\\GeneratorEntityBundle'Controller"],
        ];
    }

    /**
     * @dataProvider dataForMethodIsNamespaceValidFirstBackslashNotMandatory
     */
    public function testIsNamespaceValidFirstBackslashNotMandatory($namespace)
    {
        $this->assertTrue(Tools::isNamespaceValid($namespace, false));
    }

    public function dataForMethodIsNamespaceValidFirstBackslashNotMandatory()
    {
        return [
            ["GeneratorEntityBundle\\Entity\\NotExistingYetEntityType"],
            ["GeneratorEntityBundle\\NotExistingYet\\EntityType"],
        ];
    }

    /**
     * @dataProvider dataForTestIsValidPropertyNameString
     */
    public function testIsValidPropertyNameString($name, $result)
    {
        $this->assertEquals(Tools::isValidPropertyNameString($name), $result);
    }

    public function dataForTestIsValidPropertyNameString()
    {
        return [
            ['email', true],
            ['name', true],
            ['name2', true],
            ['na3me', true],
            ['na3me', true],
            ['full_name', true],
            [' name', false],
            ['name ', false],
            [' name ', false],
            ['', false],
            [null, false],
            [false, false],
            [true, false],
            ['3name', false],
            ['\name', false],
            ['na!me', false],
            ['na@me', false],
            ['na#me', false],
            ['na$me', false],
            ['na%me', false],
            ['na^me', false],
            ['na&me', false],
            ['na(me', false],
            ['na*me', false],
            ['na)me', false],
            ['na)me', false],
            ['na,me', false],
            ['na.me', false],
            ['na"me', false],
            ['na~me', false],
            ['na`me', false],
            ['na me', false],
            ['_', false],
            ['9', false],
        ];
    }

    /**
     * @dataProvider dataForTestIsValidPropertyTypeString
     */
    public function testIsValidPropertyTypeString($name, $result)
    {
        $this->assertEquals(Tools::isValidPropertyTypeString($name), $result);
    }

    public function dataForTestIsValidPropertyTypeString()
    {
        return [
            ['integer', true],
            ['string', true],
            ['array', true],
            ['array<Some\Object>', true],
            ['boolean', true],
            ['float', true],
            ['double', true],
            ['DateTime', true],
            ["DateTime<'format'>", true],
            ['Doctrine\Common\Collections\ArrayCollection', true],
            ['Doctrine\Common\Collections\ArrayCollection<string>', true],
            ['Doctrine\Common\Collections\ArrayCollection<Some\Object>', true],
            ['Doctrine\Common\Collections\ArrayCollection<string, Some\Object>', true],
            ['\\', false],
            ['', false],
            [null, false],
            [false, false],
            [true, false],
            [true, false],
            ['int!eger', false],
            ['int@eger', false],
            ['int#eger', false],
            ['int$eger', false],
            ['int%eger', false],
            ['int^eger', false],
            ['int&eger', false],
            ['int(eger', false],
            ['int*eger', false],
            ['int)eger', false],
            ['int)eger', false],
            ['int.eger', false],
            ['int"eger', false],
            ['int~eger', false],
            ['int`eger', false],
            ['9', false],
            ['\DateTime', false],
            ['array<\Some\Object>', false],
            ['\Some\Object', false],
        ];
    }

    public function testExplodeTemplateStringToArray()
    {
        $this->assertEquals(3, count(Tools::explodeTemplateStringToArray("foo\nbar\n")));
        $this->assertEquals(2, count(Tools::explodeTemplateStringToArray("foo\n")));
        $this->assertEquals(1, count(Tools::explodeTemplateStringToArray("foo")));
    }

    public function testImplodeArrayToTemplate()
    {
        $this->assertEquals("foo\nbar", Tools::implodeArrayToTemplate(["foo", "bar"]));
        $this->assertEquals("foo\nbar\n", Tools::implodeArrayToTemplate(["foo", "bar", ""]));
        $this->assertEquals("foo\n\nbar", Tools::implodeArrayToTemplate(["foo", "", "bar"]));
        $this->assertEquals("foo", Tools::implodeArrayToTemplate(["foo"]));
        $this->assertEquals("foo\n", Tools::implodeArrayToTemplate(["foo", ""]));
    }

    /**
     * @dataProvider dataForTestIsCallableConstraintAnnotation
     */
    public function testIsCallableConstraintAnnotation($constraint, $result)
    {
        $this->assertEquals($result, Tools::isCallableConstraintAnnotation($constraint));
    }

    public function dataForTestIsCallableConstraintAnnotation()
    {
        return [
            ["@\Symfony\Component\Validator\Constraints\Valid()", true],
            ["@\Symfony\Component\Validator\Constraints\Valid(message=\"Has to be valid!\")", true],
            ["@Symfony\Component\Validator\Constraints\Valid()", true],
            ["@Symfony\Component\Validator\Constraints\Valid(message=\"Has to be valid!\")", true],
            ["@Symfony\Component\Validator\Constraints\Valid(sdfgsdfgsdfgsdgsdg)", true], // @todo in the future
            ["@Symfony\Component\Validator\Constraints\NotExistConstraint()", false],
            ["@Symfony\Component\Validator\Constraints\Valid", false],
            ["@Symfony\Component\Validator\Constraints\Valid(", false],
            ["@Symfony\Component\Validator\Constraints\Valid)", false],
            ["Symfony\Component\Validator\Constraints\Valid()", false],
            ["@Symfony-Component\Validator\Constraints\Valid()", false],
            ["@Symfony-Component\Validator\Constraints", false],
            [null, false],
            ["", false],
            ["4l594276974569-0df70-trt7wre", false],
            ['', false],
            ["@\Symfony\Component\Validator\Constraints\@\Symfony\Component\Validator\Constraints\Valid()", false],
        ];
    }

    /**
     * @dataProvider dataForTestIsFirstCharBackslash
     */
    public function testIsFirstCharBackslash($string, $result)
    {
        $this->assertEquals($result, Tools::isFirstCharBackslash($string));
    }

    public function dataForTestIsFirstCharBackslash()
    {
        return [
            ["\\LoremIpsum", true],
            ["LoremIpsum", false],
            ["LoremIpsum\\", false],
            ["Lorem\\Ipsum", false],
            ["\\", true],
            ["", false],
            ['', false],
        ];
    }

    /**
     * @dataProvider dataForTestIsFirstCharBackslashWhenInvalidString
     * @expectedException \Exception
     */
    public function testIsFirstCharBackslashWhenInvalidString($value)
    {
        Tools::isFirstCharBackslash($value);
    }

    public function dataForTestIsFirstCharBackslashWhenInvalidString()
    {
        return [
            [null],
            [34],
            [[]],
        ];
    }
}
