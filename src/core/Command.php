<?php

namespace Glicerine\core;

use Glicerine\console\Color;
use Glicerine\console\Output;
use Glicerine\validators\Validator;
use Glicerine\validators\ValidatorFactory;

/**
 * Base Command class
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Command
{
    /**
     * @var CliParams
     */
    private $params;
    private $errors;

    final public function __construct(CliParams $params)
    {
        $this->params = $params;
        $this->init();
    }

    protected function init()
    {
        
    }

    protected function validationRules()
    {
        return [];
    }

    public function validateParams($action): bool
    {
        
        $ruleset = $this->validationRules();
        $actionRules = $ruleset[$action] ?? [];
        $validatorFactory = new ValidatorFactory();

        foreach($actionRules as $paramName => $rules) {
            foreach($rules as $ruleDefinition) {
                
                $validator = $validatorFactory->buildValidator($ruleDefinition);

                $param = $this->getParam($paramName);
                if(!$validator->validate($param)) {
                    $this->addErrors($paramName, $validator->getErrors());
                } elseif($validator->isFiltering()) {
                    $this->params->setParam($paramName, $validator->getFilteredParam());
                }
            }
        }
        return !$this->hasErrors();
    }

    protected function addErrors(string $param, array $errors)
    {
        if(!isset($this->errors[$param])) {
            $this->errors[$param] = [];
        }
        $this->errors[$param] = array_merge($this->errors[$param], $errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function getParam(string $paramName)
    {
        return $this->params->getParam($paramName);
    }

    public function help()
    {
        Output::writeLine("Will show help here", Color::GREEN);
    }

    public function printErrors()
    {
        Output::writeLine('Validation errors:');
        foreach ($this->errors as $param => $errors) {
            foreach($errors as $error) {
                Output::writeLine($param.': '.$error, Color::RED);
            }
            
        }
    }

}
