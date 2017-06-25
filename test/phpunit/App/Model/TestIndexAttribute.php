<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Tests for classes with attributes with the Index domain
 *
 * Uses $object->{$attribute_or_function_name} not call_user_func to invoke methods
 *
 * @author davethemac
 */
trait TestIndexAttribute {
    use TestIndexProvider;

    /**
     * Summary of getIndexTest
     *
     * @param str $name Name of the attribute
     * @param str $getter Getter method for the attribute
     */
    public function getIndexTest($name, $getter = null) {

        // set the getter method by naming convention if no specific method supplied
        if(is_null($getter)){
            $getter = 'get'. ucfirst($name);
        }

        // assert attribute exists in object
        $this->assertClassHasAttribute($name, get_class($this->object));

        // assert attribute exists in object
        $this->assertObjectHasAttribute($name, $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data[$name], $this->object->{$getter}());

    }

    /**
     * Summary of setIndexTest
     *
     * @param str $name Name of the attribute
     * @param str $getter Getter method for the attribute
     * @param str $setter Setter method for the attribute
     */
    public function setIndexTest($name, $getter = null, $setter = null) {

        // set the getter method by naming convention if no specific method supplied
        if(is_null($getter)){
            $getter = 'get'. ucfirst($name);
        }

        // set the setter method by naming convention if no specific method supplied
        if(is_null($setter)){
            $setter = 'set'. ucfirst($name);
        }

        // set an arbitrary valid value
        $data = 2;
        // set the attribute and test fluent interface
        $this->assertEquals($this->object, $this->object->{$setter}($data));
        // test object value
        $this->assertEquals($data, $this->object->{$getter}());
    }

    /**
     * Summary of setIndexTest
     *
     * @param str $name Name of the attribute
     * @param mixed $parameter from the integerTypeErrorProvider
     * @param str $setter Setter method for the attribute
     */
    public function setIntegerTypeErrorTest($parameter, $name, $setter = null) {
        // set the setter method by naming convention if no specific method supplied
        if(is_null($setter)){
            $setter = 'set'. ucfirst($name);
        }
        // we expect an IntegerTypeError
        $this->expectException(\Error::class);
        // set the attribute
        $this->object->{$setter}($parameter);
    }

    /**
     * Summary of setIndexTest
     *
     * @param str $name Name of the attribute
     * @param mixed $parameter from the invalidIndexProvider
     * @param str $setter Setter method for the attribute
     */
    public function setInvalidIndexTest($parameter, $name, $setter = null) {
        // set the setter method by naming convention if no specific method supplied
        if(is_null($setter)){
            $setter = 'set'. ucfirst($name);
        }
        // we expect an InvalidIndex exception
        $this->expectException(\InvalidArgumentException::class);
        // set the attribute
        $this->object->{$setter}($parameter);
    }

}
