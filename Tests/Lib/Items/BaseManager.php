<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;

use Doctrine\Common\Collections\ArrayCollection;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Helper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Tests\Loader\Validator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base Item Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class BaseManager extends KernelTestCase
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    /**
     * @return Validator
     */
    protected function getValidator()
    {
        return $this->container->get('validator');
    }

    /**
     * Prepare correct ClassManager
     *
     * @return ClassManager
     */
    protected function preapareClassManager()
    {
        $classManager = new ClassManager();
        $classManager->setNamespace("\AppBundle\Entity\User");
        $classManager->setComment("User entity for tests");

        $propertiesCollection = new ArrayCollection();
        $propertiesCollection->add(Helper::prepareProperty("full_name", "string", "", ["NotBlank()"]));
        $propertiesCollection->add(Helper::prepareProperty("email", "string", "", ["Email(message = 'Invalid email!')"]));
        $propertiesCollection->add(Helper::prepareProperty("active", "boolean", "Wether user active", ["Type(type='boolean')", "True()"]));
        $propertiesCollection->add(Helper::prepareProperty("new_posts", "Doctrine\Common\Collections\ArrayCollection<AppBundle\Entity\Post>", "User new posts", ["NotNull()", "Valid()"]));

        $classManager->setProperties($propertiesCollection);

        return $this->container->get('seg.structure_generator')->preapareClassManager($classManager);
    }
}
