<?php

namespace Glicerine\validators;

/**
 * Description of ListValidator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ListValidator extends Validator
{

    protected $delimiter = ",";

    protected function validateParam() : bool
    {
        return $this->isValidList();
    }

    private function isValidList()
    {
        $regex = "/^([^" . $this->delimiter . "])+(" . $this->delimiter . "[^" . $this->delimiter . "]+)*$/";
        return preg_match($regex, $this->param) !== 0;
    }

    protected function filterParam()
    {
        return explode($this->delimiter, $this->param);
    }

    protected function buildErrorMessage() : string
    {
        return "'{param}' is not a valid list. Use the list delimited by '$this->delimiter'";
    }
}
