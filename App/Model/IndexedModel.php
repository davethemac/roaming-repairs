<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * At this point IndexedModel exists just for the convenience of IndexModelTest
 * Although we could use it structurally in application
 * 'Abstract' super class of model objects with an integer used as an index
 *
 * @author davethemac
 */
class IndexedModel {
    //put your code here

    /** @var int the id of the model element */
    protected $id; // int

    /**
     *
     * @param array $data
     */
    public function __construct($data) {
        if(isset($data['id'])){
            $this->id = $data['id'];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = (int)$id;
        return $this;
    }

}
