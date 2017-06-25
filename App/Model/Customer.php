<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of Customer
 *
 * @author davethemac
 */
class Customer {
    //put your code here
    protected $id;
    private $firstName;
    private $lastName;

    public function __construct(array $data) {

        if(isset($data['id'])){
            $this->id = $data['id'];
        }
        if(isset($data['firstName'])){
            $this->firstName = $data['firstName'];
        }
        if(isset($data['lastName'])){
            $this->lastName = $data['lastName'];
        }

    }

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setId(int $id) {
        $this->id = (int)$id;
        return $this;
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
