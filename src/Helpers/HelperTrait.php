<?php

namespace NuWorks\Generator\Helpers;

trait HelperTrait
{
	/**
     * Get the ClassName.
     * 
     * @param  string  $value  String to be fix
     * 
     * @return string
     */ 
    protected function getClassName($value)
    {
        return str_replace('.php', '', $value);
    }

	/**
     * Transforms the namespaces to ucfirst
     * 
     * @param  array  $value  Value to be iterated
     * 
     * @return array
     */
    protected function fixNamespaceToUpper($value)
    {
        if($value) {
            foreach($value as $key => $string) {
                $value[$key] = ucfirst($string);
            }
        }

        return $value;
    }

    /**
     * Evaluate if the given path is existing
     * 
     * @param  string  $value  Path to be evaluated
     * 
     * @return boolean (inverted)
     */
    protected function notValidDirectory($value)
    {
        return !$this->files->isDirectory($value);
    }

    /**
     * Get the configuration error, returns null if none.
     *
     * @param   mixed  $value  Value to be evaluated.
     *
     * @return  mixed
     */
    protected function getConfigurationError($value)
    {
        if(is_null($value)) {
            return 'The console configuration is not configured correctly.';
        }

        return $this->message;
    }

    /**
     * Validate if a file already exists.
     * 
     * @param  string  $file  The full path and the file itself
     * 
     * @return mixed
     */
    protected function fileExists($file)
    {
        if($this->files->exists($file)) {
            return 'File already exists.';
        }

        return null;
    }

    /**
     * Get the stub template.
     * 
     * @return  string
     */
    protected function getStub($type)
    {
        return $this->files->get(__DIR__ .'/../Stubs/' .ucfirst($type). '.stub');
    }
}