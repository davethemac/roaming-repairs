<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

/**
 * A Component represents a Part used in the overall construction of a Device
 * Since a given Part could be used in more than one Device, this class represents
 * the association between a Part and a Device, and might be optional or required
 * Part and Component are synonyms so there is potential for confusion.
 * It might seem more natural to swap the names for Component and Part
 * so we get Component b is Part c of Device a
 * rather than Part b is Component c of Device a
 * splitting hairs though...
 *
 * @author davethemac
 */
class Component {
    //put your code here
    private $deviceId; // int
    private $partId; // int
    private $quantity; // int
    // possibly $role // string

    public function __construct(array $data) {

        if(isset($data['device_id'])){
            $this->deviceId = (int)$data['device_id'];
        }
        if(isset($data['part_id'])){
            $this->partId = (int)$data['part_id'];
        }
        if(isset($data['quantity'])){
            $this->quantity = (int)$data['quantity'];
        }
    }

    public function getDeviceId() {
        return $this->deviceId;
    }

    public function getPartId() {
        return $this->partId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setDeviceId($deviceId) {
        $this->deviceId = $deviceId;
        return $this;
    }

    public function setPartId($partId) {
        $this->partId = $partId;
        return $this;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

}
