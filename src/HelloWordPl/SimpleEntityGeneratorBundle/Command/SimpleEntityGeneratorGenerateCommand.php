<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\ClassConfig;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\StructureWithMethodsInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class SimpleEntityGeneratorGenerateCommand extends ContainerAwareCommand
{

    const PARAM_BUNDLE_NAME = 'bundle_name';
    const PARAM_FILE_NAME = 'file_name';
    const OPTION_NO_INTERFACES = 'no-interfaces';
    const OPTION_NO_PHPUNIT_CLASSES = 'no-phpunit-classes';
    const OPTION_ONLY_SIMULATE_FILE = 'only-simulate-file';

    protected function configure()
    {
        $this
            ->setName('class_generator:generate')
            ->setDescription('Generate entities from yaml bundle config file')
            ->addArgument(self::PARAM_BUNDLE_NAME, InputArgument::REQUIRED, 'Name of bundle where config file is placed eg. AppBundle')
            ->addArgument(self::PARAM_FILE_NAME, InputArgument::REQUIRED, sprintf('Name of yaml config file eg. entities.yml placed in /{%s}/Resources/config/{%s}', self::PARAM_BUNDLE_NAME, self::PARAM_FILE_NAME))
            ->addOption(self::OPTION_NO_INTERFACES, null, InputOption::VALUE_NONE, 'Switches off interfaces generating')
            ->addOption(self::OPTION_NO_PHPUNIT_CLASSES, null, InputOption::VALUE_NONE, 'Switches off PHPUnit classes generating')
            ->addOption(self::OPTION_ONLY_SIMULATE_FILE, null, InputOption::VALUE_NONE, 'Simulation of generating classes from file and show summary');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $classConfig = new ClassConfig();
            $classConfig->setNoInterface($input->getOption(self::OPTION_NO_INTERFACES));
            $classConfig->setNoPHPUnitClass($input->getOption(self::OPTION_NO_PHPUNIT_CLASSES));
            $onlySimulate = $input->getOption(self::OPTION_ONLY_SIMULATE_FILE);

            $bundleName = $input->getArgument(self::PARAM_BUNDLE_NAME);
            $fileName = $input->getArgument(self::PARAM_FILE_NAME);

            $filesManager = $this->getFilesManager();
            $structureGenerator = $this->getStructureGenerator();

            $fileContent = $filesManager->loadFileContent($bundleName, $fileName);
            $entitiesData = $structureGenerator->parseToArray($fileContent);
            $classManagers = $structureGenerator->buildEntitiesClassStructure($entitiesData, $classConfig);

            $this->checkClassesDuplicate($classManagers);
            $this->validateClasses($classManagers);

            $output->writeln('ClassGenerator 1.1.0 by Slawomir Kania and contributors.');
            $output->writeln('');
            if ($onlySimulate) {
                $output->writeln(sprintf('<comment>[Generating and updating classes is disabled] Simulation for file: %s, in bundle: %s started. Please wait for summary...</comment>', $fileName, $bundleName));
            } else {
                $output->writeln(sprintf('<info>Start generating classes from config file: %s, in bundle: %s. Please wait...</info>', $fileName, $bundleName));
            }
            $output->writeln('');

            $this->processStructures($output, $classManagers, $onlySimulate);

            $output->writeln('<info>Finished!</info>');
        } catch (Exception $ex) {
            throw new Exception(sprintf('Error occured, message: %s, trace: %s', $ex->getMessage(), $ex->getTraceAsString()));
        }
    }

    /**
     * Dump structures into files
     *
     * @param OutputInterface $output
     * @param ArrayCollection $classManagers
     * @throws Exception
     */
    protected function processStructures(OutputInterface $output, ArrayCollection $classManagers, $onlySimulate = false)
    {
        foreach ($classManagers as $classManager) {
            /* @var $classManager \HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager */
            if (false === ($classManager instanceof ClassManager)) {
                throw new Exception(sprintf("Invalid entity: %s", get_class($classManager)));
            }

            $this->processInterface($output, $classManager, $onlySimulate);
            $this->processClass($output, $classManager, $onlySimulate);
            $this->processTestClass($output, $classManager, $onlySimulate);

            $output->writeln('');
        }
    }

    /**
     * Dump interface to file
     *
     * @param OutputInterface $output
     * @param ClassManager $classManager
     * @param boolean $onlySimulate
     * @return
     */
    protected function processInterface(OutputInterface $output, ClassManager $classManager, $onlySimulate = false)
    {
        if (false === $classManager->hasInterface()) {
            return;
        }

        $interfaceManager = $classManager->getInterface();

        if (false === $onlySimulate) {
            $filesManager = $this->getFilesManager();
            $filesManager->dump($interfaceManager);
        }

        $output->writeln('<question>Processed: '.$interfaceManager->getNamespace()."</question>");
        $this->outputProcessMethods($output, $interfaceManager);

        $output->writeln('');
    }

    /**
     * Dump class to file
     *
     * @param OutputInterface $output
     * @param ClassManager $classManager
     * @param boolean $onlySimulate
     */
    protected function processClass(OutputInterface $output, ClassManager $classManager, $onlySimulate = false)
    {
        if (false === $onlySimulate) {
            $filesManager = $this->getFilesManager();
            $filesManager->dump($classManager);
        }

        $output->writeln('<question>Processed: '.$classManager->getNamespace().'</question>');
        if ($classManager->getProperties()->isEmpty()) {
            $output->writeln('No properties to add');
        } else {
            $output->writeln('<comment>properties:</comment>');
            foreach ($classManager->getProperties() as $classProperty) {
                $output->writeln(sprintf(" - %s: %s", $classProperty->getPreparedName(), $classProperty->getType()));
            }
        }

        $this->outputProcessMethods($output, $classManager);

        $output->writeln('');
    }

    /**
     * Dump TestClass to file
     *
     * @param OutputInterface $output
     * @param ClassManager $classManager
     * @param boolean $onlySimulate
     * @return
     */
    protected function processTestClass(OutputInterface $output, ClassManager $classManager, $onlySimulate = false)
    {
        if (false === $classManager->hasTestClass()) {
            return;
        }

        $testClassManager = $classManager->getTestClass();

        if (false === $onlySimulate) {
            $filesManager = $this->getFilesManager();
            $filesManager->dump($testClassManager);
        }

        $output->writeln('<question>Processed: '.$classManager->getTestClass()->getNamespace().'</question>');
        $this->outputProcessMethods($output, $testClassManager);
        if (false === $testClassManager->getMethods()->isEmpty()) {
            $output->writeln(sprintf('<comment>Implement missing assertions in %s</comment>', $testClassManager->getNamespace()));
        }
        $output->writeln('');
    }

    /**
     * Throw Exception when duplicated classes
     *
     * @param ArrayCollection $classManagers
     * @throws Exception
     */
    protected function checkClassesDuplicate(ArrayCollection $classManagers)
    {
        $checkDuplicateArray = [];
        foreach ($classManagers as $classManager) {
            $checkDuplicateArray[] = $classManager->getNamespace();
        }

        if (count(array_unique($checkDuplicateArray)) < count($checkDuplicateArray)) {
            throw new Exception("Duplicated classes in bundle!");
        }
    }

    /**
     * Throw Exception when class entities invalid
     *
     * @param ArrayCollection $classManagers
     * @throws Exception
     */
    protected function validateClasses(ArrayCollection $classManagers)
    {
        $validator = $this->getValidator();
        $constraintViolationList = $validator->validate($classManagers);

        if ($constraintViolationList->count() > 0) {
            throw new Exception(sprintf("Structure validation errors: %s", $constraintViolationList));
        }
    }

    /**
     * @return \HelloWordPl\SimpleEntityGeneratorBundle\Lib\FilesManager
     */
    protected function getFilesManager()
    {
        return $this->getContainer()->get('seg.files_manager');
    }

    /**
     * @return \HelloWordPl\SimpleEntityGeneratorBundle\Lib\StructureGenerator
     */
    protected function getStructureGenerator()
    {
        return $this->getContainer()->get('seg.structure_generator');
    }

    /**
     * @return \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected function getValidator()
    {
        return $this->getContainer()->get('validator');
    }

    /**
     * Output rendered methods
     *
     * @param OutputInterface $output
     * @param StructureWithMethodsInterface $item
     */
    private function outputProcessMethods(OutputInterface $output, StructureWithMethodsInterface $item)
    {
        if ($item->getMethods()->isEmpty()) {
            $output->writeln('No methods to add');
        } else {
            $output->writeln('<comment>methods:</comment>');
            foreach ($item->getMethods() as $method) {
                $output->writeln(sprintf(" - %s", $method->getPreparedName()));
            }
            $output->writeln('');
        }
    }
}
