<?php

namespace Glicerine\validators;

/**
 * Description of Validator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
abstract class Validator
{
    protected $param;
    protected $filter = true;
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

    }

    protected function addError(string $error)
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    final public function validate(string $param): bool
    {
        $this->param = $param;
        $paramValid = $this->validateParam();
        if ($this->filter) {
            $this->filterParam();
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
}
