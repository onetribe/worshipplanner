<?php

namespace App;

trait HasValidationRulesTrait
{

   /**
    * Returns the default validation rules for a song
    *
    * @return array
    **/
   public function getValidationRules()
   {
        return $this->defaultValidationRules;
   }
}