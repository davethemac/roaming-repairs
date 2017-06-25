<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of Device
 *
 * @author davethemac
 */
class Device {
    //put your code here
    protected $id;
    protected $name;

    public function __construct(array $data) {

        if(isset($data['id'])){
            $this->id = $data['id'];
        }
        if(isset($data['name'])){
            $this->name = $data['name'];
        }

    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setId(int $id) {
        $this->id = (int)$id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

}
