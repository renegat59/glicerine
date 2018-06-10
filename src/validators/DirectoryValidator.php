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
        if (strpbrk($this->param, "?%*:|\"<>") !== false) {
            $this->addError("'{param}' is not a valid directory string");
            return false;
        }
        if($this->checkExists && !is_dir($this->param)) {
            $this->addError("{param} directory does not exist");
            return false;
        }
        return true;
    }
}
