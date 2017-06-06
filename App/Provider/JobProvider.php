<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Provider;

use App\Model\Job;
use App\Provider\PartUsedProvider;
use App\Provider\WorkerProvider;

/**
 * Description of JobProvider
 *
 * N.B. these aren't strictly silex providers, more object managers
 *
 * @author david.mccart
 */
class JobProvider extends AbstractObjectProvider {

    /** @var App\Provider\PartsUsedProvider */
    private $partsUsedProvider;
    /** @var App\Provider\WorkerProvider */
    private $workerProvider;

    public function __construct(\PDO $con, $table, PartUsedProvider $partsUsedProvider, WorkerProvider $workerProvider) {
        parent::__construct($con, $table);
        $this->partsUsedProvider = $partsUsedProvider;
        $this->workerProvider = $workerProvider;
    }

    protected function createObject(array $data){

        $job = new Job($data); // probablt don't need to inject 'this' into the job, cos we diden't go down that route

        // load associations
        if($job->getId()){
            // get workers
            $personnel = $this->getPersonel($job->getId());
            foreach ($personnel as $worker){
                $job->addWorker($worker);
            }
            // get parts used
            $partsUsed = $this->getPartsUsed($job->getId());
            foreach($partsUsed as $partUsed){
                $job->addPartUsed($partUsed);
            }
        }

        return $job;
    }

    public function persist($object){

        // build sql
        if($object->getId()){
            $pre = 'UPDATE ';
            $post = ' WHERE id = :id';
        }else{
            $pre = 'INSERT INTO ';
            $post = '';
        }
        $sql = $pre . $this->getTable() . ' SET ' .
                'reference_no = :reference_no, customer_id = :customer_id, description = :description, job_date = :job_date, mileage = :mileage,' .
                'start_time = :start_time, end_time = :end_time, is_complete = :is_complete, parlour_test = :parlour_test, notes = :notes' . $post;


        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':reference_no', $object->getReferenceNo(), \PDO::PARAM_INT);
            $stmt->bindValue(':customer_id', $object->getCustomerId(), \PDO::PARAM_INT);
            $stmt->bindValue(':description', $object->getDescription(), \PDO::PARAM_STR);
            $stmt->bindValue(':job_date', $object->getJobDate()->format('Y-m-d'), \PDO::PARAM_STR);
            $stmt->bindValue(':mileage', $object->getMileage(), \PDO::PARAM_INT);
            $stmt->bindValue(':start_time', $object->getStartTime(), \PDO::PARAM_STR);
            $stmt->bindValue(':end_time', $object->getEndTime(), \PDO::PARAM_STR);
            $stmt->bindValue(':is_complete', $object->getIsComplete(), \PDO::PARAM_BOOL);
            $stmt->bindValue(':parlour_test', $object->getParlourTest(), \PDO::PARAM_BOOL);
            $stmt->bindValue(':notes', $object->getNotes(), \PDO::PARAM_STR);

            $stmt->execute();

            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }

            $this->persistPersonel($object);

        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
            var_dump($object);
        }
    }

    // object specific methods
    public function getOwnedBy($userId){}

    // deferred methods
    public function getPartsUsed($jobId){
        // defer to App\Provider\PartsUsedProvider
        return $this->partsUsedProvider->getByJobId($jobId);
    }

    public function getPersonel($jobId){
        // defer to App\Provider\WorkerProvider
        return $this->workerProvider->getByJobId($jobId);
    }

    public function getByReferenceNo($refNo){
        // create generic sql query
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE reference_no = ?';
        try{
            $stmt = $this->con->prepare($sql);
            // bind the index paramater
            $stmt->bindValue(1, $refNo, \PDO::PARAM_INT);
            if($stmt->execute()===false){
                // throws an exception in debug mode
                // do some kind of error handling...
                return false;
            }
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data===false){
                // throws an exception in debug mode
                // do some other kind of error handling
                return $this->createObject(array());
            }
            # THIS MIGHT NOT BE ENOUGH CHECKING, TEST BY FORCING A NOT FOUND RESULT
            // for the result, create an object and stuff it with data
            // we don't know what kind of object to create
            return $this->createObject($data);

        } catch (\Exception $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

    protected function persistPersonel($job){
        // check if there is anything to do first
        $personnel = $job->getWorkerIds();
        if(!is_array($personnel) || count($personnel) === 0){
            return;
        }

        // build sql
        $sql = 'INSERT INTO rr_job_worker(job_id, worker_id) VALUES';
        $numRows = count($personnel);
        // add multiple rows with placeholders
        for($i=0; $i<$numRows; $i++){
            if($i>0){
                $sql .= ',';
            }
            $sql .= '(?, ?)';
        }
        // add the mysql specific duplicate key clause
        $sql .= ' ON DUPLICATE KEY UPDATE job_id = VALUES(job_id), worker_id = VALUES(worker_id)';
        try{
            $stmt = $this->con->prepare($sql);
            $paramCount = 0;
            foreach($personnel as $workerId){
                // bind each row pf placeholders..
                $stmt->bindValue(++$paramCount, $job->getId(), \PDO::PARAM_INT);
                $stmt->bindValue(++$paramCount, $workerId, \PDO::PARAM_INT);
            }
            $stmt->execute();

        } catch (\Exception $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
    }

}
