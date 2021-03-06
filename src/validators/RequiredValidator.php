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
        if(empty($this->param)) {
            $this->addError('value is required');
            return false;
        }
        return true;
    }

}
