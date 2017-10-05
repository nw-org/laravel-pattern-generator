<?php

namespace NuWorks\PatternGenerator\Core;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

abstract class PatternGenerator extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $fileSystem;

    /**
     * The namespace field.
     *
     * @var string
     */
    protected $namespace;

    /**
     * The class type field.
     * 
     * @var string
     */
    protected $classType;

    /**
     * The class suffix field.
     * 
     * @var string
     */
    protected $classSuffix;

    /**
     * The stub path field.
     * 
     * @var string
     */
    protected $stubPath;

    /**
     * The pattern generator class constructor.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $fileSystem
     *
     * @return void
     */
    public function __construct(Filesystem $fileSystem)
    {
        /**
         * Invoke the parent __construct(...) method.
         *
         * @uses \Illuminate\Console\Command
         */
        parent::__construct();

        $this->setFileSystem($fileSystem);
    }

    /**
     * The setter method for the file system field.
     *
     * @param \Illuminate\Filesystem\Filesystem  $fileSystem
     *
     * @return void
     */
    protected function setFileSystem($fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * The getter method for the file system field.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    protected function getFileSystem()
    {
        return $this->fileSystem;
    }

    /**
     * The setter method for the namespace field.
     *
     * @param string  $namespace
     *
     * @return void
     */
    protected function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * The getter method for the namespace field.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * The setter method for the class type field.
     *
     * @param string  $classType
     *
     * @return void
     */
    protected function setClassType($classType)
    {
        $this->classType = $classType;
    }

    /**
     * The getter method for the class type field.
     *
     * @return string
     */
    protected function getClassType()
    {
        return $this->classType;
    }

    /**
     * The setter method for the class suffix field.
     *
     * @param string  $classSuffix
     *
     * @return void
     */
    protected function setClassSuffix($classSuffix)
    {
        $this->classSuffix = $classSuffix;
    }

    /**
     * The getter method for the class suffix field.
     *
     * @return string
     */
    protected function getClassSuffix()
    {
        return $this->classSuffix;
    }

    /**
     * The setter method for the stub path field.
     *
     * @param string  $stubPath
     *
     * @return void
     */
    protected function setStubPath($stubPath)
    {
        $this->stubPath = $stubPath;
    }

    /**
     * The getter method for the stub path field.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return $this->stubPath;
    }

    /**
     * Get the laravel root namespace definition.
     *
     * @return string
     */
    protected function getLaravelRootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    /**
     * Get the laravel root path definition.
     *
     * @return string
     */
    protected function getLaravelRootPath()
    {
        return $this->laravel['path'];   
    }

    protected function generate()
    {
        /**
         * @todo
         */
    }

    /**
     * @Override
     */
    protected function getNameInput()
    {

    }

    /**
     * @Override
     */
    protected function getFolderOptionInput()
    {

    }

    /**
     * Get the class file name base path.
     * 
     */
    private function getPath($name)
    {
        $rootNamespace = $this->getLaravelRootNamespace();
        $rootPath = $this->getLaravelRootPath();

        $filename = str_replace_first($rootNamespace, '', $name);
        $resolvedFilename = str_replace('\\', '/', $filename);
        
        return "{$rootPath}/{$rootNamespace}/{$resolvedFilename}.php";
    }

    /**
     * Set to the base Command class the arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the pattern generator - class.'],
        ];
    }
}
