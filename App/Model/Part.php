<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of Part
 *
 * @author davethemac
 */
class Part {
    private $id; // int
    private $partNumber; // probably a string, but could be an integer, you never know
    private $description;

    public function __construct(array $data) {

        if(isset($data['id'])){
            $this->id = $data['id'];
        }
        if(isset($data['part_number'])){
            $this->partNumber = $data['part_number'];
        }
        if(isset($data['description'])){
            $this->description = $data['description'];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getPartNumber() {
        return $this->partNumber;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
    $this->id = (int)$id;
    return $this;
    }

    public function setPartNumber($partNumber) {
    $this->partNumber = $partNumber;
    return $this;
    }

    public function setDescription($description) {
    $this->description = $description;
    return $this;
    }
}

