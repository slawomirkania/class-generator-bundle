<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InitPropertyManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;

/**
 * InitPropertyManager Test
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class InitPropertyManagerTest extends BaseManager
{

    /**
     * @var InitPropertyManager
     */
    protected $initPropertyManager = null;

    /**
     * SET UP
     */
    public function setUp()
    {
        parent::setUp();
        $initProperties = $this->prepareClassManager()->getConstructor()->getInitProperties();
        $this->initPropertyManager = $initProperties->first();
    }

    public function testManger()
    {
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface', $this->initPropertyManager);
        $this->assertInstanceOf('\HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InitPropertyManager', $this->initPropertyManager);
    }

    public function testValidManagerWhenValid()
    {
        $errors = $this->getValidator()->validate($this->initPropertyManager);
        $this->assertEquals(0, $errors->count());
    }

    public function testValidManagerWhenEmptyProperty()
    {
        $this->initPropertyManager->setProperty(new PropertyManager());
        $errors = $this->getValidator()->validate($this->initPropertyManager);
        $this->assertEquals(4, $errors->count());
    }
}
