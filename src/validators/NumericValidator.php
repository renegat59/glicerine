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
    protected $onlyPositive = false;
    protected $onlyNegative = false;
    protected $nonZero = false;
    protected $min = false;
    protected $max = false;

    protected function validateParam(): bool
    {
        $validNumeric = $this->validNumeric();
        $validInt = $this->validInt();
        $validRange =  $this->validRange();
        return $validNumeric && $validInt && $validRange;
    }

    private function validNumeric()
    {
        return is_numeric($this->param);
    }

    private function validRange()
    {
        $validMin = ($this->min !== false) ? ($this->param >= $this->min) : true;
        $validMax = ($this->max !== false) ? ($this->param <= $this->max) : true;
        return $validMin && $validMax;
    }

    private function validInt()
    {
        if($this->onlyInt) {
            return is_numeric($this->param) && $this->param == (int) $this->param;
        }
        return true;
    }

    private function validFloat()
    {
        
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
        return '{param} is not a valid numeric value';
    }
}
