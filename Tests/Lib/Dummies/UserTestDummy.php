<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Dummies;

/**
 * User dummy test class for StructureResolver tests
 */
class UserTestDummy extends \PHPUnit_Framework_TestCase
{

    /**
     * Entity to test
     * @var \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface
     */
    private $object = null;

    public function setUp()
    {
        $this->object = new \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User();
    }

    public function testConstructor()
    {
        $this->assertNotNull($this->object);
        $this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\UserInterface', $this->object);
        $this->assertInstanceof('\SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User', $this->object);
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setFullName
     */
    public function testSetFullName()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getFullName
     */
    public function testGetFullName()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setEmail
     */
    public function testSetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getEmail
     */
    public function testGetEmail()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::isActive
     */
    public function testIsActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setActive
     */
    public function testSetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getActive
     */
    public function testGetActive()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::setNewPosts
     */
    public function testSetNewPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \SimpleEntityGeneratorBundle\Tests\Lib\Dummies\User::getNewPosts
     */
    public function testGetNewPosts()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::setRoles
     */
    public function testSetRoles()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \AppBundle\Entity\User::getRoles
     */
    public function testGetRoles()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
