<?php

namespace HelloWordPl\SimpleEntityGeneratorBundle\Lib;

use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Interfaces\RenderableInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Config\FileLocator;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassConstructorManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\InterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\TestMethodManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodGetterBooleanInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\ClassManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\MethodSetterInterfaceManager;
use HelloWordPl\SimpleEntityGeneratorBundle\Lib\Items\PropertyManager;

/**
 * @author Sławomir Kania <slawomir.kania1@gmail.com>
 */
class TemplateManager
{

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * CONSTRUCT
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param RenderableInterface $item
     */
    public function loadAndSetTemplateOnItem(RenderableInterface $item)
    {
        $this->resolveAndSetTemplatePathIfCan($item);
        $template = null;
        if (false === empty($item->getTemplate())) {
            $template = $item->getTemplate();
        } elseif (false === empty($item->getTemplatePath())) {
            $path = $this->getFileLocator()->locate("@".$item->getTemplatePath()); // may throw exception
            $template = $this->getFilesManager()->loadContentFromFile($path);
        } else {
            // default template
            $reflect = new \ReflectionClass($item);
            $paramName = $reflect->getShortName()."TemplatePath";

            if (false === $this->kernel->getContainer()->hasParameter($paramName)) {
                throw new \RuntimeException(sprintf("No parameter %s set", $paramName));
            }

            $path = $this->getFileLocator()->locate("@".$this->kernel->getContainer()->getParameter($paramName)); // may throw exception
            $template = $this->getFilesManager()->loadContentFromFile($path);
        }

        $item->setTemplate($template);
    }

    /**
     * @return FilesManager
     */
    public function getFilesManager()
    {
        return $this->kernel->getContainer()->get("seg.files_manager");
    }

    /**
     * @return FileLocator
     */
    public function getFileLocator()
    {
        return $this->kernel->getContainer()->get("file_locator");
    }

    /**
     * @param RenderableInterface $item
     */
    protected function resolveAndSetTemplatePathIfCan(RenderableInterface $item)
    {
        $templatePath = "";
        switch (true) {
            case $item instanceof ClassManager:
                $templatePath = $item->getClassManagerTemplatePath();
                break;
            case $item instanceof PropertyManager:
                $templatePath = $item->getPropertyManagerTemplatePath();
                break;
            case $item instanceof ClassConstructorManager:
                $templatePath = $item->getClassManager()->getClassConstructorManagerTemplatePath();
                break;
            case $item instanceof InterfaceManager:
                $templatePath = $item->getClassManager()->getInterfaceManagerTemplatePath();
                break;
            case $item instanceof TestClassManager:
                $templatePath = $item->getClassManager()->getTestClassManagerTemplatePath();
                break;
            case $item instanceof TestMethodManager:
                $templatePath = $item->getMethod()->getProperty()->getTestClassMethodManagerTemplatePath();
                break;
            case $item instanceof MethodGetterManager:
                $templatePath = $item->getProperty()->getMethodGetterManagerTemplatePath();
                break;
            case $item instanceof MethodGetterInterfaceManager:
                $templatePath = $item->getProperty()->getMethodGetterInterfaceManagerTemplatePath();
                break;
            case $item instanceof MethodGetterBooleanManager:
                $templatePath = $item->getProperty()->getMethodGetterBooleanManagerTemplatePath();
                break;
            case $item instanceof MethodGetterBooleanInterfaceManager:
                $templatePath = $item->getProperty()->getMethodGetterBooleanInterfaceManageTemplatePath();
                break;
            case $item instanceof MethodSetterInterfaceManager:
                $templatePath = $item->getProperty()->getMethodSetterInterfaceManagerTemplatePath();
                break;
            case $item instanceof MethodSetterManager:
                $templatePath = $item->getProperty()->getMethodSetterManagerTemplatePath();
                break;
        }

        if (false === empty($templatePath)) {
            $item->setTemplatePath($templatePath);
        }
    }
}
