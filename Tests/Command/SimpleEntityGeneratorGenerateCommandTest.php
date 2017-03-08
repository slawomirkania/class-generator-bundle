<?php

namespace SimpleEntityGeneratorBundle\Tests\Command;

use SimpleEntityGeneratorBundle\Command\SimpleEntityGeneratorGenerateCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application as App;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class SimpleEntityGeneratorGenerateCommandTest extends WebTestCase
{
    private $application = null;

    public function setUp()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $this->application = new App($kernel);
        $this->application->add(new SimpleEntityGeneratorGenerateCommand());
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\RuntimeException
     * @expectedExceptionMessage Not enough arguments (missing: "bundle_name, file_name")
     */
    public function testRunCommandWithoutArguments()
    {
        $command = $this->application->find('class_generator:generate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
    }
}
