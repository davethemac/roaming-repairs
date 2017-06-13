<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * Description of PartUsed
 *
 * @author davethemac
 */
class PartUsed {

    private $id; // int
    private $jobId; // int
    private $componentId; // int
    private $partNo; // redunant field Part::partNumber
    private $description;
    private $quantity; // int


    public function __construct(array $data) {

        if(isset($data['id'])){
            $this->id = (int)$data['id'];
        }
        if(isset($data['job_id'])){
            $this->jobId = (int)$data['job_id'];
        }
        if(isset($data['component_id'])){
            $this->componentId = (int)$data['component_id'];
        }
        if(isset($data['usage_description'])){
            $this->description = $data['usage_description'];
        }
        if(isset($data['quantity'])){
            $this->quantity = (int)$data['quantity'];
        }
        if(isset($data['part_number'])){
            $this->partNo = $data['part_number'];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getJobId() {
        return $this->jobId;
    }

    public function getComponentId() {
        return $this->componentId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setId($id) {
        $this->id = (int)$id;
        return $this;
    }

    public function setJobId($jobId) {
        $this->jobId = (int)$jobId;
        return $this;
    }

    public function setComponentId($componentId) {
        $this->componentId = (int)$componentId;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = (int)$quantity;
        return $this;
    }

    public function getPartNo() {
        return $this->partNo;
    }

    public function setPartNo($partNo) {
        $this->partNo = $partNo;
        return $this;
    }


}
