<?php

namespace Glicerine\core;

use Glicerine\console\Color;
use Glicerine\console\Output;
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

    
    final public function actions(): array
    {
        $enabledActions = $this->enabledActions();
        if(!empty($enabledActions)) {
            return array_merge($enabledActions, ['help']);
        }
        return [];
    }

    /**
     * This function returns the list of enabled actions.
     * This is to be able to enable/disable the actions if needed.
     * If array is empty (No actions defined) then all actions are enabled by default.
     */
    protected function enabledActions(): array
    {
        return [];
    }

    protected function init()
    {
        return;
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
            foreach($rules as $vaildatorDefinition) {
                $validator = $validatorFactory->buildValidator($vaildatorDefinition);
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
