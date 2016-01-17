<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Exceptions\FilesManagerException;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\DumpableInterface;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Renderer;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\StructureResolver;
use ReflectionClass;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Files Manager
 * - load structure from yaml
 * - create directory if do not exist
 * - update exisiting sources
 *
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class FilesManager
{

    /**
     * @var KernelInterface
     */
    private $kernel = null;

    /**
     * CONSTR
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Load class structure from yaml file to array array('{"data":"data"}', '{"data":"data"}')
     * File has to be placed in to the directory src/{bundleName}/Resources/config/{fileName}
     *
     * @param string $bundleName
     * @param string $fileName
     * @return string
     */
    public function loadFileContent($bundleName, $fileName)
    {
        $fileDirectory = sprintf('%s/../src/%s/Resources/config/%s', $this->getKernel()->getRootDir(), $bundleName, $fileName);
        $result = file_get_contents($fileDirectory);
        if (is_bool($result) && false == $result) {
            throw new FilesManagerException(sprintf("Can not load file from: %s", $fileDirectory));
        }

        return $result;
    }

    /**
     * Create or update item file
     *
     * @param DumpableInterface $item
     * @throws FilesManagerException
     */
    public function dump(DumpableInterface $item)
    {
        try {
            if ($this->isItemFileExists($item)) {
                $this->updateExistingFile($item); // working on reference
            } else {
                $this->createDirectoryIfNeedAndFileAndDumpContent($item);
            }

            return $item;
        } catch (IOExceptionInterface $e) {
            throw new FilesManagerException("An error occurred while creating your directory at ".$e->getPath());
        }
    }

    /**
     * @param DumpableInterface $item
     * @return boolean
     */
    public function isItemFileExists(DumpableInterface $item)
    {
        $fs = $this->getFilesystem();
        $fullFileDirectory = $this->getItemDirectoryWithClassNameAndExtension($item);

        return $fs->exists($fullFileDirectory);
    }

    /**
     * @param DumpableInterface $item
     * @throws FilesManagerException
     */
    public function checkItemFileExists(DumpableInterface $item)
    {
        if (false == $this->isItemFileExists($item)) {
            throw new FilesManagerException(sprintf("Item source file does not exist: %s", $item->getNamespace()));
        }
    }

    /**
     * @param DumpableInterface $item
     * @return ReflectionClass
     * @throws FilesManagerException
     */
    public function getReflectionClassForItem(DumpableInterface $item)
    {
        $this->checkItemFileExists($item);
        return new ReflectionClass($item->getNamespace());
    }

    /**
     * @param DumpableInterface $item
     * @return string
     * @throws FilesManagerException
     */
    public function getContentFromItemFile(DumpableInterface $item)
    {
        $this->checkItemFileExists($item);
        $fullFileDirectory = $this->getItemDirectoryWithClassNameAndExtension($item);
        return file_get_contents($fullFileDirectory);
    }

    /**
     * @param DumpableInterface $item
     * @throws FilesManagerException
     */
    protected function updateExistingFile(DumpableInterface $item)
    {
        $fs = $this->getFilesystem();
        $content = $this->getContentFromItemFile($item);
        $reflectionClass = $this->getReflectionClassForItem($item);
        $updatedContent = $this->getStructureResolver()->getUpdatedItemSourceContent($content, $item, $reflectionClass);
        if (false == empty($updatedContent)) {
            $fs->dumpFile($this->getItemDirectoryWithClassNameAndExtension($item), $updatedContent);
        }

        return $item;
    }

    /**
     * @param DumpableInterface $item
     * @throws FilesManagerException
     */
    protected function createDirectoryIfNeedAndFileAndDumpContent(DumpableInterface $item)
    {
        $fs = $this->getFilesystem();
        $fullFileDirectory = $this->getItemDirectoryWithClassNameAndExtension($item);
        $directory = $this->getItemDirectory($item);
        if (false == $fs->exists($directory)) {
            $fs->mkdir($directory);
        }

        $fs->touch($fullFileDirectory);
        if (false == $fs->exists($fullFileDirectory)) {
            throw new FilesManagerException("Structure file can not be created");
        }

        $content = $this->getRenderer()->render($item);
        if (false == empty($content)) {
            $fs->dumpFile($fullFileDirectory, $content);
        }
    }

    /**
     * @return KernelInterface
     */
    protected function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return new Filesystem();
    }

    /**
     * @param DumpableInterface $item
     * @return string
     */
    protected function getItemDirectory(DumpableInterface $item)
    {
        return sprintf('%s/../src%s', $this->getKernel()->getRootDir(), $item->getDirectory());
    }

    /**
     * @param DumpableInterface $item
     * @return string
     */
    protected function getItemDirectoryWithClassNameAndExtension(DumpableInterface $item)
    {
        return sprintf("%s/%s.php", $this->getItemDirectory($item), $item->getName());
    }

    /**
     * @return StructureResolver
     */
    protected function getStructureResolver()
    {
        return $this->getKernel()->getContainer()->get("seg.structure_resolver");
    }

    /**
     * @return Renderer
     */
    protected function getRenderer()
    {
        return new Renderer();
    }
}
