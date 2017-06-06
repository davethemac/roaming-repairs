<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of MyDate
 *
 * @author david.mccart
 * @Annotation
 */
class MyDate extends Constraint {
    
    public $message = 'This value is not a valid date.';
}
