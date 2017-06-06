<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Description of MyTimeValidator
 *
 * @author david.mccart
 */
class MyTimeValidator extends ConstraintValidator{
    
    public function validate($value, Constraint $constraint) {
        try{
            $time = strtotime($value);
            unset($time);
        } catch (\Exception $ex) {
            $this->context->buildViolation($constraint->message)
                    ->addViolation();
        }
    }

}
