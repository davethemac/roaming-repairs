<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of Worker
 *
 * @author david.mccart
 */
class Worker {
    //put your code here
    private $id; // int
    private $firstName;
    private $lastName;
    
    public function __construct($data) {

        if(isset($data['id'])){
            $this->id = $data['id'];
        }
        if(isset($data['first_name'])){
            $this->firstName = $data['first_name'];
        }
        if(isset($data['last_name'])){
            $this->lastName = $data['last_name'];
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

    public function setId($id) {
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
