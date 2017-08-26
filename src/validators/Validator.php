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

    protected abstract function validateParam();

    public function __construct($params = [])
    {
        foreach($params as $param => $value) {
            if(property_exists($this, $param)) {
                $this->$param = $value;
            }
        }
        $this->setParams($params);
    }

    /**
     * Optionally we can set some params here if they are not straightforward
     * @param type $params
     */
    protected function setParams($params = [])
    {
        // ??
    }

    protected function addError(string $error)
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    final public function validate($param): bool
    {
        $this->param = $param;
        $paramValid = $this->validateParam();
        if ($this->filter) {
            $this->filterParam();
        }
        if(!$paramValid) {
            $this->addError($this->errorMessage);
        }
        return $paramValid;
    }
    
    protected function filterParam()
    {
        return;
    }

    public function getFilteredParam()
    {
        return $this->param;
    }

    public function isFiltering(): bool
    {
        return $this->filter;
    }

    public static function build($validatorDefinition)
    {
        $validatorClass = '';
        $validatorAttributes = [];
        if(is_string($validatorDefinition)){
            $validatorClass = $validatorDefinition;
        } elseif (is_array($validatorDefinition)) {
            if(!isset($validatorDefinition['class'])){
                throw new InvalidConfigurationException(
                    'Rule definition must have class field'
                );
            }
            $validatorClass = $validatorDefinition['class'];
            unset($validatorDefinition['class']);
            $validatorAttributes = $validatorDefinition ?? [];
        }

        return new $validatorClass($validatorAttributes);
    }
}
