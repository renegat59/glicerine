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

  public function __construct($name, $description)
  {
    $this->name = $name;
    $this->description = $description;
    return $this;
  }

  public function addParamDescription($param, $description)
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
      $this->addRule($param, $rule);
    }
  }

  public function getValidationRules() {
    return $this->rules;
  }
}
