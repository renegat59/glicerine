<?php

namespace Glicerine\validators;

/**
 * Boolean Validator - allows 1/0 or True/False (case insensitive)
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class BooleanValidator extends Validator
{
    /**
     * If we set this array we only accept given values as a TRUE and FALSE.
     * The first value (index 0) is a representant of TRUE, second (index 1) FALSE
     * @var type
     */
    protected $tfValues = [];

    protected function validateParam(): bool
    {
        if(!$this->isValidTrue() && !$this->isValidFalse()) {
            $this->addError($this->buildErrorMessage());
            return false;
        }
        return true;
    }

    protected function filterParam()
    {
        if($this->isValidTrue())
        {
            return true;
        }
        if($this->isValidFalse())
        {
            return false;
        }
    }

    private function isValidTrue()
    {
        if(!empty($this->tfValues)) {
            return 0 === strcmp($this->tfValues[0], $this->param);
        }
        return $this->param == '1' || 0 === strcasecmp('true', $this->param);
    }

    private function isValidFalse()
    {
        if(!empty($this->tfValues)) {
            return 0 === strcmp($this->tfValues[1], $this->param);
        }
        return $this->param == '0' || 0 === strcasecmp('false', $this->param);
    }

    private function buildErrorMessage(): string
    {
        $message = "'{param}' is not a valid boolean value.";
        if(!empty($this->tfValues)) {
            $message .= ' Alowed values are '.implode('/', $this->tfValues);
        } else {
            $message .= ' Alowed values are 1/0 OR true/false';
        }
        return $message;
    }
}
