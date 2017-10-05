<?php

namespace NuWorks\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use NuWorks\Generator\Helpers\HelperTrait;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepositoryCommand extends Command
{
    use HelperTrait;

    /**
     * The console command.
     * 
     * @var  string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     * 
     * @var  string
     */
    protected $description = 'Create a new repository file';

    /**
     * The filesystem instance.
     * 
     * @var  Filesystem
     */
    protected $files;

    /**
     * The error message.
     *
     * @var  mixed
     */
    protected $message = null;
    
    /**
     * Create a new repository install command instance
     * 
     * @param   Filesystem $files
     *
     * @return  void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     * 
     * @return  void
     */
    public function handle()
    {
        if($message = $this->getConfigurationError($this->getRepositoryDirectory())) {
            return $this->error($message);
        }

        $this->createRepositoryFile();
    }

    /**
     * Create the repository files.
     * 
     * @return  void
     */
    protected function createRepositoryFile()
    {
        $directory = $this->getRepositoryDirectory();
        $filename = $this->getNameArgument() .'.php';
        $clean_path_to_file = base_path() .'/'. $this->fixDirectoryPath($directory) . $filename;

        if($error = $this->fileExists($clean_path_to_file)) {
            return $this->error($error);
        }

        $stub = str_replace(
            ['{{ Namespace }}', '{{ ClassName }}'],
            [$this->getNamespace($directory), $this->getClassName($filename)],
            $this->getStub('repository')
        );

        if($this->notValidDirectory($this->fixDirectoryPath($directory))) {
            return $this->error('The path you specified on your configuration file is not valid.');
        }

        if($this->files->put($clean_path_to_file, $stub)) {
            return $this->info('Repository created.');
        }
    }

    /**
     * Get the Namespace.
     * 
     * @param  string   $value                String to be fix
     * @param  boolean  $with_trailing_slash  Remove or retain the trailing slash
     * 
     * @return string
     */
    protected function getNamespace($value, $with_trailing_slash = false)
    {
        $segmented_value = explode('/', $value);

        if(isset($segmented_value[0]) && strtolower($segmented_value[0]) == 'app') {
            unset($segmented_value[0]);
        }

        $value = implode($segmented_value, '\\');
        $fix_namespace = implode($this->fixNamespaceToUpper($segmented_value), '\\');

        return $with_trailing_slash === false ? rtrim($fix_namespace, '\\') : $value;
    }

    /**
     * Convert back slashes to forward slashes.
     * 
     * @param  string  $value  Value to be evaluated
     * 
     * @return string
     */
    protected function fixDirectoryPath($value)
    {
        $value = $this->getNamespace($value, $return_fixed = true);

        return str_replace('\\', '/', $value);
    }

    /**
     * Get the name argument.
     *
     * @return  string
     */
    protected function getNameArgument()
    {
        return trim($this->argument('name'));
    }    

    /**
     * Get the repository directory from the configuration
     * file that has been published.
     * 
     * @return  mixed
     */
    protected function getRepositoryDirectory()
    {
        $directory = $this->laravel['config']['nw_generator']['repository_directory'];

        return $directory ? rtrim($directory, '\\/') .'/' : null;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository class.'],
        ];
    }
}