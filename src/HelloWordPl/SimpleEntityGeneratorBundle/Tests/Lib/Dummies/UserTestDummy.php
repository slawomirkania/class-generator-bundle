<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy test class for StructureResolver tests
 */
class UserTestDummy extends \PHPUnit_Framework_TestCase
{

    /**
     * Entity to test
     * @var \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
     */
    private $object = null;

    public function setUp()
    {
        $this->object = new \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User();
    }

    public function testConstructor()
    {
        $this->assertNotNull($this->object);
        $this->assertInstanceof('\HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface', $this->object);
        $this->assertInstanceof('\HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User', $this->object);
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setFullName
     */
    public function testSetFullName()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getFullName
     */
    public function testGetFullName()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setEmail
     */
    public function testSetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getEmail
     */
    public function testGetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::isActive
     */
    public function testIsActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setActive
     */
    public function testSetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getActive
     */
    public function testGetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setNewPosts
     */
    public function testSetNewPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getNewPosts
     */
    public function testGetNewPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
