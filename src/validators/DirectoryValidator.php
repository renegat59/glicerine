<?php

namespace Glicerine\validators;

/**
 * Description of DirectoryValidator
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class DirectoryValidator extends Validator
{

    protected $checkExists = false;

    protected function validateParam() : bool
    {
        return $this->isValidDirectory();
    }

    private function isValidDirectory() : bool
    {
        if (strpbrk($this->param, "?%*:|\"<>") === false) {
            if($this->checkExists) {
                return is_dir($this->param);
            }
            return true;
        }
        return false;
    }

    protected function buildErrorMessage(): string
    {
        $message = "{param} is not a valid directory string.";
        if($this->checkExists) {
            $message .= " Or directory does not exist";
        }
        return $message;
    }
}
