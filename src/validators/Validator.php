<?php

namespace Glicerine\validators;

use Glicerine\exceptions\InvalidConfigurationException;

/**
 * Description of Validator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Validator
{
    protected $param;
    protected $filter = true;

    /**
     * errorMessage is the message used in the default validators.
     * If user wishes to make his own validators he can add as many messages as he want
     * using addError(). Default validators have only one message which can be customized
     * by setting it in the params.
     * @var string 
     */
    protected $errorMessage = '';
    private $errors = [];

    protected abstract function validateParam() : bool;

    public function __construct($properties = [])
    {
        foreach ($properties as $property => $value) {
            if (property_exists($this, $property)) {
                $this->setProperty($property, $value);
            }
        }
    }

    public function setProperty($propertyName, $propertyValue)
    {
        if (property_exists($this, $propertyName)) {
            $this->$propertyName = $propertyValue;
        }
    }

    protected function addError(string $error)
    {
        $this->errors[] = $error;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function hasErrors() : bool
    {
        return !empty($this->errors);
    }

    final public function validate($param) : bool
    {
        $this->param = $param;
        $paramValid = $this->validateParam();
        if (!$paramValid) {
            $this->addError($this->formatErrorMessage());
        }
        return $paramValid;
    }

    protected function filterParam()
    {
        return;
    }

    /**
     * To be overriden if needed. By default returns the same param value
     */
    public function getFilteredParam()
    {
        return $this->filterParam() ?? $this->param;
    }

    public function isFiltering() : bool
    {
        return $this->filter;
    }

    protected function buildErrorMessage() : string
    {
        return $this->errorMessage;
    }

    protected function hasCustomErrorMessage()
    {
        return !empty($this->errorMessage);
    }

    private function formatErrorMessage()
    {
        $errorMessage = $this->hasCustomErrorMessage() ? $this->errorMessage : $this->buildErrorMessage();
        return str_replace('{param}', $this->param, $errorMessage);
    }
}
