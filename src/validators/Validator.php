<?php

namespace Glicerine\validators;

/**
 * Description of Validator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Validator
{
    private $errors = [];

    protected function addError(string $error)
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
