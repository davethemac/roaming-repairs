<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use App\Model\Worker;
use App\Model\PartUsed;

/**
 * Description of Job
 *
 * @author david.mccart
 */
class Job {
    
    protected $id; // int
    protected $referenceNo; // int
    protected $customerId; // int
    protected $description; // text
    protected $jobDate; // date
    protected $mileage; // int
    protected $startTime;
    protected $endTime;
    protected $isComplete; // bool
    protected $parlourTest; // bool
    protected $notes;
    // associations
    protected $workerIds; // array of worker ids assigned to this job
    protected $personnel; // array of actual worker objects assigned to this job
    protected $partsUsed; // array of part objects    
    
    public function __construct(array $data) {
        
        if(isset($data['id'])){
            $this->id = (int)$data['id'];
        }
        if(isset($data['reference_no'])){
            $this->referenceNo = $data['reference_no'];
        }
        if(isset($data['customer_id'])){
            $this->customerId = (int)$data['customer_id'];
        }
        if(isset($data['description'])){
            $this->description = $data['description'];
        }
        if(isset($data['job_date'])){
            $this->setJobDate($data['job_date']);
        }
        if(isset($data['mileage'])){
            $this->mileage = (int)$data['mileage'];
        }
        if(isset($data['start_time'])){
            $this->setStartTime($data['start_time']);
        }
        if(isset($data['end_time'])){
            $this->setEndTime($data['end_time']);
        }
        if(isset($data['is_complete'])){
            $this->isComplete = (bool)$data['is_complete'];
        }
        if(isset($data['parlour_test'])){
            $this->parlourTest = (bool)$data['parlour_test'];
        }
        if(isset($data['notes'])){
            $this->notes = $data['notes'];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getReferenceNo() {
        return $this->referenceNo;
    }

    public function getCustomerId() {
        return $this->customerId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getJobDate() {
        return $this->jobDate;
    }
    
    public function getMileage() {
        return $this->mileage;
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }

    public function getPersonnel() {
        return $this->personnel;
    }

    public function getIsComplete() {
        return $this->isComplete;
    }

    public function getParlourTest() {
        return $this->parlourTest;
    }

    public function getPartsUsed() {
        return $this->partsUsed;
    }
    
    public function getNotes() {
        return $this->notes;
    }
    
    public function getWorkerIds() {
        return $this->workerIds;
    }

    public function setId($id) {
        $this->id = (int)$id;
        return $this;
    }
    
    public function setReferenceNo($referenceNo) {
        $this->referenceNo = (int)$referenceNo;
        return $this;
    }

    public function setCustomerId($customerId) {
        $this->customerId = (int)$customerId;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setJobDate($jobDate) {
        if(is_string($jobDate)){
            $date = new \DateTime(str_replace('/', '-', $jobDate));
            $this->jobDate = $date;
            return $this;
        }
        $this->jobDate = $jobDate;
        return $this;
    }
    
    public function setMileage($mileage) {
        $this->mileage = (int)$mileage;
        return $this;
    }

    public function setStartTime($startTime) {
        if($startTime instanceof \DateTime){
            $this->startTime = $startTime;
            return $this;            
        }
        if(is_string($startTime) && strlen($startTime) > 0){
            $time = new \DateTime($startTime);
            $this->startTime = $time->format('H:i:s');
            return $this;
        }
    }

    public function setEndTime($endTime) {
        if($endTime instanceof \DateTime){
            $this->endTime = $endTime;
            return $this;
        }
        if(is_string($endTime) && strlen($endTime) > 0){
            $time = new \DateTime($endTime);
            $this->endTime = $time->format('H:i:s');
            return $this;
        }
    }

    public function setIsComplete($isComplete) {
        $this->isComplete = (bool)$isComplete;
        return $this;
    }

    public function setParlourTest($parlourTest) {
        $this->parlourTest = (bool)$parlourTest;
        return $this;
    }
    
    public function setNotes($notes) {
        $this->notes = $notes;
        return $this;
    }

    public function addWorkerId($id) {
        // we could demand worker objects as a param
        if(!is_array($this->workerIds)){
            // we could lazy load this from the db
            $this->workerIds = array();
            // but when we persist this, all we really need to do is insert values into
            // the job-worker link table...
        }
        // look and see if this worker is already in there
        foreach($this->workerIds as $worker){
            if($worker === $id){
                return $this;
            }
        }
        $this->workerIds[] = $id;
        return $this;
    }
    
    public function isWorkingOn($id){
        if(!is_array($this->workerIds)){
            // if no one is working on this job
            return false;
        }
        foreach($this->workerIds as $worker){
            if($worker === $id){
                return true;
            }
        }
        return false;
    }

    public function addWorker(Worker $worker){
        if(!is_array($this->personnel)){
            $this->personnel = array();
        }
        $this->personnel[(string)$worker->getId()] = $worker;
        $this->addWorkerId($worker->getId());
    }
    
    public function addPartUsed(PartUsed $partUsed){
        if(!is_array($this->partsUsed)){
            $this->partsUsed = array();
        }
        $this->partsUsed[(string)$partUsed->getId()] = $partUsed;
    }
    
}