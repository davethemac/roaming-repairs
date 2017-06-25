<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Provides functions define sets for testing Indexes
 *
 * Index is the domain of integer values greater than 0
 *
 * @author davethemac
 */
trait TestIndexProvider {

    /**
     * Provides set of values to cause integer type error
     *
     * Values are not integers and can't be converted to integers
     *
     * @return mixed
     */
    public function integerTypeErrorProvider(){
        return [
            [null], // null
            ['two'], // string
            [[]] // array
            ];
    }

    /**
     * Provides set of values to cause InvalidArgumentException
     *
     * Values are integers less than 1
     *
     * @return mixed
     */
    public function invalidIndexProvider(){
        return [
            [-1],
            [0],
            ];
    }

}
