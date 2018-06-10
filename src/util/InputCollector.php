<?php

namespace Glicerine\util;

use Glicerine\core\ActionPrototype;
use Glicerine\console\Output;
use Glicerine\console\Input;
use Glicerine\validators\ValidatorFactory;


/**
 * InputCollector
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class InputCollector
{
  /**
   * @var $paramsPrototype ActionPorotype
   */
  private $paramsPrototype;

  public function &proto($name = '', $description = '')
  {
    $this->paramsPrototype = new ActionPrototype($name, $description);
    return $this->paramsPrototype;
  }


  public function collect() : array
  {
    $readValues = [];
    Output::writeLine($this->paramsPrototype->getDescription());
    $paramDescriptions = $this->paramsPrototype->getParamDescriptions();
    $validatorFactory = new ValidatorFactory();
    foreach ($paramDescriptions as $param => $description) {
      $prompt = $this->buildPrompt($param, $description);
      $paramRules = $this->paramsPrototype->getValidationRules($param);
      do {
        $readValue = Input::read($prompt);
        $valid = true;
        foreach ($paramRules as $vaildatorDefinition) {
          $validator = $validatorFactory->buildValidator($vaildatorDefinition);
          if (!$validator->validate($readValue)) {
            $errors = $validator->getErrors();
            foreach($errors as $error){
              Output::writeErrorLine($error);
            }
            $valid &= false;
          } elseif ($validator->isFiltering()) {
            $readValue = $validator->getFilteredParam();
          }
        }
      } while (!$valid);
      $readValues[$param] = $readValue;
    }
    return $readValues;
  }

  private function buildPrompt($param = '', $description = '')
  {
    $prompt = $param;
    if (!empty($description)) {
      $prompt .= " ($description)";
    }
    $prompt .= ":";
    return $prompt;
  }
}