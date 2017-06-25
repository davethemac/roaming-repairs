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
    use TestNameAttribute;

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
        // use TestNameAttribute trait
        $this->getNameTest('firstName');
    }

    /**
     * @covers ::getLastName
     * @todo   Implement testGetLastName().
     */
    public function testGetLastName() {
        // use TestNameAttribute trait
         $this->getNameTest('lastName');
   }

    /**
     * @covers ::setFirstName
     * @todo   Implement testSetFirstName().
     */
    public function testSetFirstName() {
        // use TestNameAttribute trait
        $this->setNameTest('firstName');
    }

    /**
     * @covers ::setLastName
     * @todo   Implement testSetLastName().
     */
    public function testSetLastName() {
        // use TestNameAttribute trait
        $this->setNameTest('lastName');
   }

}
