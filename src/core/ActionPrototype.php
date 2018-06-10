<?php

namespace Glicerine\core;

/**
 * Action Prototype
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ActionPrototype
{
  private $name;
  private $description;
  private $rules = [];
  private $descriptions = [];

  public function __construct($name='', $description='')
  {
    $this->name = $name;
    $this->description = $description;
    return $this;
  }

  public function addParamDescription($param, $description = '')
  {
    $this->descriptions[$param] = $description;
    return $this;
  }

  public function addParamRule($param, $rule)
  {
    if(!isset($this->rules[$param])) {
      $this->rules[$param] = [];
    }
    array_push($this->rules[$param], $rule);
    return $this;
  }

  public function addParamRules($param, $rules)
  {
    foreach($rules as $rule) {
      $this->addParamRule($param, $rule);
    }
    return $this;
  }

  public function getValidationRules($param=null) {
    if($param !== null) {
      return $this->rules[$param];
    }
    return $this->rules;
  }

  public function getParamDescriptions() {
    $descriptions = $this->descriptions;
    //add empty descriptions for each param that has defined rules:
    foreach($this->rules as $param => $rule) {
      if(!isset($descriptions[$param])) {
        $descriptions[$param] = '';
      }
    }

    return $descriptions;
  }

  public function getValidatorNames($param){
    $validatorNames = [];
    foreach($this->rules[$param] as $rule) {
      $vName = '';
      if(is_array($rule)){
        $vName = $rule['class'];
      }
      if(is_string($rule)){
        $vName = $rule;
      }
      if ($pos = strrpos($vName, '\\')){
        $vName = substr($vName, $pos + 1);
      } 
      $validatorNames[] = strtolower(str_replace('Validator', '', $vName));
    }
    return $validatorNames;
  }

  public function getDescription() {
    return $this->description;
  }
}
