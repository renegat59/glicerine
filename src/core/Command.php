<?php

namespace Glicerine\core;

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

    public function validateParams(): bool
    {
        $rulset = $this->validationRules();
        foreach($rulset as $paramName => $rules) {
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

    protected function getParam(string $paramName): string
    {
        return $this->params->getParam($paramName);
    }

}
