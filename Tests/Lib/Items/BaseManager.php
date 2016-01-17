<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Tests\Lib\Items;


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

    /**
     * SET UP
     */
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
        return $this->container->get('seg.structure_generator')->preapareClassManager(Helper::prepareBasicClassManager());
    }
}
