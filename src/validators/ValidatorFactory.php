<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
