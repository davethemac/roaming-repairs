<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of TestNameAttribute
 *
 * @author davethemac
 */
trait TestNameAttribute {

    public function getNameTest($name, $getter = null){

        // set the getter method by naming convention if no specific method supplied
        if(is_null($getter)){
            $getter = 'get'. ucfirst($name);
        }
    // assert attribute exists in object
        $this->assertClassHasAttribute($name, get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute($name, $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data[$name], $this->object->{$getter}());
    }

    public function setNameTest($name, $getter = null, $setter = null){

        // set the getter method by naming convention if no specific method supplied
        if(is_null($getter)){
            $getter = 'get'. ucfirst($name);
        }
        // set the setter method by naming convention if no specific method supplied
        if(is_null($setter)){
            $setter = 'set'. ucfirst($name);
        }
        $data = 'Paul';
        // test fluent interface
        $this->assertEquals($this->object, $this->object->{$setter}($data));
        // test object value
        $this->assertEquals($data, $this->object->{$getter}());
    }
}
