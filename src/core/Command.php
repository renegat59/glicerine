<?php

namespace Glicerine\core;

/**
 * Base Command class
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Command
{
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
        
    }

    public function validateParams(): boolean
    {
        $rulset = $this->validationRules();
        foreach($rulset as $param => $rules) {
            foreach($rules as $ruleDefinition) {
                $validatorClass = '';
                $validatorParams = [];
                if(is_string($ruleDefinition)){
                    $validatorClass = $ruleDefinition;
                } elseif (is_array($ruleDefinition)) {
                    if(!isset($ruleDefinition['class'])){
                        throw new \Glicerine\exceptions\InvalidConfigurationException(
                            'Rule definition must have class field'
                        );
                    }
                    $validatorClass = $ruleDefinition['class'];
                    $validatorParams = $ruleDefinition['params'] ?? [];
                }
                $validator = new $validatorClass($validatorParams);
                if(!$validator->validate($param)) {
                    $this->addErrors($param, $validator->getErrors());
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

    public function hasErrors(): boolean
    {
        return !empty($this->errors);
    }

    protected function getParam(string $paramName): string
    {
        return $this->params->getParam($paramName);
    }

}
