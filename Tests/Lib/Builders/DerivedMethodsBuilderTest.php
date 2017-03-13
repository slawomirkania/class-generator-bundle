<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Builders;

use Doctrine\Common\Collections\ArrayCollection;
use SimpleEntityGeneratorBundle\Lib\Builders\DerivedMethodsBuilder;
use SimpleEntityGeneratorBundle\Tests\Lib\Items\BaseManager;
use Symfony\Component\Security\Core\User\UserInterface;

class DerivedMethodsBuilderTest extends BaseManager
{
    private $classManager;

    public function setUp()
    {
        parent::setUp();
        $this->classManager = self::prepareClassManager();
    }


    public function testGetMethodsDerivedFromInterface()
    {
        $derivedMethodsBuilder = new DerivedMethodsBuilder(UserInterface::class, $this->classManager);

        $result = $derivedMethodsBuilder->getMethodsDerivedFromInterface();
        $this->assertInstanceOf(ArrayCollection::class, $result);
        $this->assertEquals('getRoles', $result[0]->getPreparedName());
        $this->assertEquals('getPassword', $result[1]->getPreparedName());
        $this->assertEquals('getSalt', $result[2]->getPreparedName());
        $this->assertEquals('getUsername', $result[3]->getPreparedName());
        $this->assertEquals('eraseCredentials', $result[4]->getPreparedName());

    }

    public function testSkippedMethods()
    {
        $derivedMethodsBuilder = new DerivedMethodsBuilder(UserInterface::class, $this->classManager);
        $derivedMethodsBuilder->setMethodsToSkip(['getSalt','getPassword','getUsername']);

        $result = $derivedMethodsBuilder->getMethodsDerivedFromInterface();
        $this->assertInstanceOf(ArrayCollection::class, $result);
        $this->assertEquals('getRoles', $result[0]->getPreparedName());
        $this->assertEquals('eraseCredentials', $result[1]->getPreparedName());

    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInterfaceNamespaceNotSet()
    {
        new DerivedMethodsBuilder(null, $this->classManager);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage NonExistentInterface could not be loaded
     */
    public function testInterfaceNotExists()
    {
        new DerivedMethodsBuilder('NonExistentInterface', $this->classManager);
    }
}
