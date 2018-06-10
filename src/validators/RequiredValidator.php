<?php

namespace Glicerine\validators;

/**
 * Description of RequiredValidator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class RequiredValidator extends Validator
{
    
    protected function validateParam(): bool
    {
        return !empty($this->param);
    }

    protected function buildErrorMessage() : string
    {
        return "is required";
    }
}
