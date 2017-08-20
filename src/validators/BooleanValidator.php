<?php

namespace Glicerine\validators;

/**
 * Boolean Validator - allows 1/0 or True/False (case insensitive)
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class BooleanValidator extends Validator
{
    protected function validateParam()
    {
        return $this->isValidTrue() || $this->isValidFalse();
    }

    protected function filterParam()
    {
        if($this->isValidTrue())
        {
            $this->param = true;
        }
        if($this->isValidFalse())
        {
            $this->param = false;
        }
    }

    private function isValidTrue()
    {
        return $this->param == '1' || 0 === strcasecmp('true', $this->param);
    }

    private function isValidFalse()
    {
        return $this->param == '0' || 0 === strcasecmp('false', $this->param);
    }
}
