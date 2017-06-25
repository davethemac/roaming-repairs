<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Model\IndexedModelTest;
use App\Model\Person;

/**
 * Description of PersonTest
 *
 * @author david
 */
class PersonTest extends IndexedModelTest {
    //put your code here

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->data = [
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Smith'
        ];
        $this->object = new Person($this->data);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers ::getFirstName
     * @todo   Implement testGetFirstName().
     */
    public function testGetFirstName() {
        // assert attribute exists in object
        $this->assertClassHasAttribute('firstName', get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute('firstName', $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data['firstName'], $this->object->getFirstName());
    }

    /**
     * @covers ::getLastName
     * @todo   Implement testGetLastName().
     */
    public function testGetLastName() {
        // assert attribute exists in object
        $this->assertClassHasAttribute('lastName', get_class($this->object));
        // assert attribute exists
        $this->assertObjectHasAttribute('lastName', $this->object);
        // assert attribute has expected type and value
        $this->assertSame($this->data['lastName'], $this->object->getLastName());
    }

    /**
     * @covers ::setFirstName
     * @todo   Implement testSetFirstName().
     */
    public function testSetFirstName() {
        $data = 'Paul';
        // test fluent interface
        $this->assertEquals($this->object, $this->object->setFirstName($data));
        // test object value
        $this->assertEquals($data, $this->object->getFirstName());
    }

    /**
     * @covers ::setLastName
     * @todo   Implement testSetLastName().
     */
    public function testSetLastName() {
        $data = 'Jones';
        // test fluent interface
        $this->assertEquals($this->object, $this->object->setLastName($data));
        // test object value
        $this->assertEquals($data, $this->object->getLastName());
    }

}
