<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Provider;

use App\Model\Worker;

/**
 * Description of WorkerProvider
 *
 * @author david.mccart
 */
class WorkerProvider extends AbstractObjectProvider{

    protected function createObject(array $data) {
        return new Worker($data);
    }

    public function persist($object) {

        // build sql
        if($object->getId()){
            $sql = 'UPDATE ' . $this->getTable() . ' SET first_name = :first_name, last_name = :last_name WHERE id = :id';
        }else{
            $sql = 'INSERT INTO ' . $this->getTable() . '(first_name, last_name) VALUES(:first_name, :last_name)';
        }

        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':first_name', $object->getFirstName(), \PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $object->getLastName(), \PDO::PARAM_STR);
            $stmt->execute();
            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }
        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

    public function addTestWorkers(){
        $workers[] = $this->createObject(array('first_name' => 'Fred', 'last_name' => 'Flintstone'));
        $workers[] = $this->createObject(array('first_name' => 'Barney', 'last_name' => 'Rubble'));
        $workers[] = $this->createObject(array('first_name' => 'Zaphod', 'last_name' => 'Breeblebrox'));
        foreach($workers as $worker){
            $this->persist($worker);
        }
    }

    public function getByJobId($jobId) {
        // build sql
        $sql = 'SELECT * FROM ' . $this->getTable() . ' LEFT JOIN rr_job_worker ON ' . $this->getTable() . '.id = rr_job_worker.worker_id '
                . 'WHERE rr_job_worker.job_id = :job_id';

        // ini array to hold objects
        $objects = array();
        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':job_id', $jobId, \PDO::PARAM_INT);

            if($stmt->execute()===false){
                // throws an exception in debug mode
                // do some kind of error handling...
                return false;
            }
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($result===false){
                // throws an exception in debug mode
                // do some other kind of error handling
                return false;
            }elseif(count($result)===0){
                // do some other kind of error handling
                // since this condition represents normal program execution,
                // return the empty array
                return $objects;
            }
            foreach($result as $data){
                // for each row, create an object and stuff it with data
                // we don't know what kind of object to create
                $objects[] = $this->createObject($data);
            }
            return $objects;

            } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
    }

    public function getWorkers(array $ids){
         // build sql
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id IN (:worker_ids)';

        // ini array to hold objects
        $objects = array();
        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':worker_ids', implode(',', $ids), \PDO::PARAM_INT);

            if($stmt->execute()===false){
                // throws an exception in debug mode
                // do some kind of error handling...
                return false;
            }
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            if($result===false){
                // throws an exception in debug mode
                // do some other kind of error handling
                return false;
            }elseif(count($result)===0){
                // do some other kind of error handling
                // since this condition represents normal program execution,
                // return the empty array
                return $objects;
            }
            foreach($result as $data){
                // for each row, create an object and stuff it with data
                // we don't know what kind of object to create
                $objects[] = $this->createObject($data);
            }
            return $objects;

            } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
    }

}
