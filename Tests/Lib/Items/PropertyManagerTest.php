<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;

/**
 * PropertyManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class PropertyManagerTest extends BaseManager
{

    /**
     * @var PropertyManager
     */
    protected $propertyManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $this->propertyManager = $this->prepareClassManager()->getProperties()->last();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->propertyManager);
        $this->assertInstanceOf('\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager', $this->propertyManager);
        $this->assertEquals('User new posts', $this->propertyManager->getComment());
        $this->assertEquals('new_posts', $this->propertyManager->getName());
        $this->assertEquals('newPosts', $this->propertyManager->getPreparedName());
        $this->assertEquals('Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>', $this->propertyManager->getType());
        $this->assertEquals('Doctrine\Common\Collections\ArrayCollection', $this->propertyManager->getTypeName());
        $this->assertEquals(2, count($this->propertyManager->getConstraints()));
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->propertyManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmpty()
    {
        $errors = $this->getValidator()->validate(new PropertyManager());
        $this->assertEquals(4, $errors->count());
    }
}
