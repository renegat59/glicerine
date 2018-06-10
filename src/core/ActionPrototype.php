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

  public function addParamRules($param, $rules)
  {
    $this->rules[$param] = $rules;
    return $this;
  }
}
