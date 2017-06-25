<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Model\IndexedModel;

/**
 * Description of Person
 *
 * @author davethemac
 */
class Person extends IndexedModel{
    //put your code here
    protected $firstName;
    protected $lastName;

    public function __construct($data) {

        parent::__construct($data);

        if(isset($data['firstName'])){
            $this->firstName = $data['firstName'];
        }
        if(isset($data['lastName'])){
            $this->lastName = $data['lastName'];
        }
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }

}
