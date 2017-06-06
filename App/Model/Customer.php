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
 * @author david.mccart
 */
class Customer {
    //put your code here
    protected $id;
    protected $name;
    
    public function __construct(array $data) {
        
        if(isset($data['id'])){
            $this->id = $data['id'];
        }
        if(isset($data['customer_name'])){
            $this->name = $data['customer_name'];
        }
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId($id) {
        $this->id = (int)$id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }


}
