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
    private $validationRules = [];
    private $currentAction = null;
    protected $actionInfo = [];

    final public function __construct(CliParams $params)
    {
        $this->params = $params;
        $this->init();
    }

    protected function init()
    {
        return;
    }

    final public function actions() : array
    {
        $definedActions = array_keys($this->actionInfo);
        return array_merge($definedActions, ['help']);
    }

    protected function &proto($actionName, $actionDescription)
    {
        $this->actionInfo[$actionName] = new ActionPrototype($actionName, $actionDescription);
        return $this->actionInfo[$actionName];
    }

    private function getValidationRules($action)
    {
        return $this->actionInfo[$action] ?? [];
    }

    public function validateParams($action) : bool
    {
        $actionRules = $this->getValidationRules($action);
        var_dump($actionRules);
        $validatorFactory = new ValidatorFactory();

        foreach ($actionRules as $paramName => $rules) {
            foreach ($rules as $vaildatorDefinition) {
                $validator = $validatorFactory->buildValidator($vaildatorDefinition);
                $param = $this->getParam($paramName);
                if (!$validator->validate($param)) {
                    $this->addErrors($paramName, $validator->getErrors());
                } elseif ($validator->isFiltering()) {
                    $this->params->setParam($paramName, $validator->getFilteredParam());
                }
            }
        }
        return !$this->hasErrors();
    }

    protected function addErrors(string $param, array $errors)
    {
        if (!isset($this->errors[$param])) {
            $this->errors[$param] = [];
        }
        $this->errors[$param] = array_merge($this->errors[$param], $errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors() : bool
    {
        return !empty($this->errors);
    }

    protected function getParam(string $paramName)
    {
        return $this->params->getParam($paramName);
    }

    public function help()
    {
        $command = $params->getComand();
        Output::writeLine("Available actions in $command:", Color::GREEN);
        $actions = $this->actions();
        foreach ($actions as $action) {
            $description = $this->actionInfo[$action]->getDescription();
            Output::writeLine("  - $action - $description", Color::GREEN);
            $paramDescriptions = $this->actionInfo[$action]->getParamDescriptions();
            foreach ($paramDescriptions as $param => $paramDescription) {
                Output::writeLine("    $param: $paramDescription", Color::GREEN);
            }
        }
    }

    public function printErrors()
    {
        Output::writeLine('Validation errors:');
        foreach ($this->errors as $param => $errors) {
            foreach ($errors as $error) {
                Output::writeLine($param . ': ' . $error, Color::RED);
            }
        }
    }

}
