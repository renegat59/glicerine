<?php

namespace Glicerine\validators;

/**
 * Description of DateValidator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DateValidator extends Validator
{
    protected $format = 'Y-m-d';

    protected function validateParam() : bool
    {
        return $this->isValidDate();
    }

    private function isValidDate() : bool
    {
        $date = \DateTime::createFromFormat($this->format, $this->param);
        if(!($date && $date->format($this->format) === $this->param))
        {
            $this->addError("'{param}' is not a valid date. Expected format: $this->format");
            return false;
        }
        return true;
    }

    protected function filterParam()
    {
        return \DateTime::createFromFormat($this->format, $this->param);
    }
}
