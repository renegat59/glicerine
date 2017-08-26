<?php

namespace Glicerine\validators;

/**
 * Description of ValidatorFactory
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ValidatorFactory
{
    public function buildValidator($validatorDefinition)
    {
        $validatorClass = '';
        $validatorAttributes = [];
        if(is_string($validatorDefinition)){
            $validatorClass = $validatorDefinition;
        } elseif (is_array($validatorDefinition)) {
            if(!isset($validatorDefinition['class'])){
                throw new InvalidConfigurationException(
                    'Rule definition must have class field'
                );
            }
            $validatorClass = $validatorDefinition['class'];
            unset($validatorDefinition['class']);
            $validatorAttributes = $validatorDefinition ?? [];
        }

        return new $validatorClass($validatorAttributes);
    }
}
