<?php

namespace Glicerine\validators;

/**
 * Description of NumericValidator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class NumericValidator extends Validator
{
    protected $onlyInt = false;
    protected $onlyFloat = false;
    protected $min = false;
    protected $max = false;
    protected $range = false;

    protected function validateParam(): bool
    {
        $validNumeric = $this->validNumeric();
        $validInt = $this->validInt();
        $validRange = $this->validRange();
        return $validNumeric && $validInt && $validRange;
    }

    private function validNumeric()
    {
        return is_numeric($this->param);
    }

    private function validRange()
    {
        if(is_array($this->range) && isset($this->range[0]) && isset($this->range[1])) {
            $this->min = $this->range[0];
            $this->max = $this->range[1];
        }
        $validMin = ($this->min !== false) ? ($this->param >= $this->min) : true;
        $validMax = ($this->max !== false) ? ($this->param <= $this->max) : true;
        return $validMin && $validMax;
    }

    private function validInt()
    {
        if($this->onlyInt) {
            return filter_var($this->param, FILTER_VALIDATE_INT);
        }
        return true;
    }

    private function validFloat()
    {
        if($this->onlyFloat) {
            return filter_var($this->param, FILTER_VALIDATE_FLOAT);
        }
        return true;
    }

    protected function filterParam()
    {
        if($this->onlyInt) {
            return (int) $this->param;
        }

        if($this->onlyFloat) {
            return (float) $this->param;
        }
    }

    protected function buildErrorMessage(): string
    {
        return "'{param}' is not a valid numeric value";
    }
}
