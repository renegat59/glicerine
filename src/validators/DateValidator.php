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
        return $date && $date->format($this->format) === $this->param;
    }

    protected function filterParam()
    {
        return \DateTime::createFromFormat($this->format, $this->param);
    }

    protected function buildErrorMessage() : string
    {
        return "{param} is not a valid date. Expected format: $this->format";
    }
}
