<?php

namespace SimpleEntityGeneratorBundle\Tests\Lib\Items;

use SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use SimpleEntityGeneratorBundle\Tests\Lib\Helper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base Item Manager
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
abstract class BaseManager extends KernelTestCase
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * SET UP
     */
    public function setUp()
    {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
    }

    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
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
    protected function prepareClassManager()
    {
        return $this->container->get('seg.structure_generator')->prepareClassManager(Helper::prepareBasicClassManager());
    }
}
