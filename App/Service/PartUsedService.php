<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use App\Model\PartUsed;
use App\Service\PartService;

/**
 * Description of PartUsedService
 *
 * @author davethemac
 */
class PartUsedService extends AbstractObjectService{

    /** @var App\Service\PartsUsedService */
    protected $partService;

    public function __construct(\PDO $con, $table, PartService $partService) {
        parent::__construct($con, $table);
        $this->partService = $partService;
    }

    protected function createObject(array $data) {
        return new PartUsed($data);
    }

    public function persist($object) {

        // build sql
        if($object->getId()){
            $sql = 'UPDATE ' . $this->getTable() . ' SET job_id = :job_id, part_id = :part_id, usage_description = :description, '
                    . 'quantity = :quantity, office_data_a = :office_data_a, office_data_b = :office_data_b WHERE id = :id';
        }else{
            $sql = 'INSERT INTO ' . $this->getTable() . '(job_id, part_id, usage_description, quantity, office_data_a, office_data_b) '
                    . 'VALUES(:job_id, :part_id, :description, :quantity, :office_data_a, :office_data_b)';
        }

        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':job_id', $object->getJobId(), \PDO::PARAM_INT);
            $stmt->bindValue(':part_id', $object->getPartId(), \PDO::PARAM_INT);
            $stmt->bindValue(':description', $object->getDescription(), \PDO::PARAM_STR);
            $stmt->bindValue(':quantity', $object->getQuantity(), \PDO::PARAM_INT);
            $stmt->bindValue(':office_data_a', $object->getOfficeDataA(), \PDO::PARAM_STR);
            $stmt->bindValue(':office_data_b', $object->getOfficeDataB(), \PDO::PARAM_STR);
            $stmt->execute();
            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }
        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

    public function getByJobId($jobId) {
        // create generic sql query
        $sql = 'SELECT ' . $this->getTable() . '.*, ' . $this->getJoinTable() .'.part_number FROM ' . $this->getCompoundTable() . ' WHERE job_id = :job_id';
        // ini array to hold objects
        $objects = array();
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

        } catch (\Exception $ex) {
            // the createObject call might throw an exception,
            // so catch all, not just PDOExceptions
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

    protected function getTable() {
        if(is_array($this->table)){
            return $this->table['table'];
        }
        return $this->table;
    }

    protected function getCompoundTable(){
        if(is_array($this->table)){
            return $this->table['table'] . ' LEFT JOIN ' . $this->table['join'] .
                    ' ON (' . $this->table['table'] . '.' . $this->table['foreign_key'] .
                    '=' . $this->table['join'] . '.' . $this->table['references'] . ')';
        }
        return $this->table;
    }

    protected function getJoinTable(){
        if(is_array($this->table)){
            return $this->table['join'];
        }
    }

    public function getAll(){
        // create generic sql query
        $sql = 'SELECT ' . $this->getTable() . '.*, ' . $this->getJoinTable() .'.part_number FROM ' . $this->getCompoundTable();
        // ini array to hold objects
        $objects = array();
        try{
            $stmt = $this->con->prepare($sql);
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

        } catch (\Exception $ex) {
            // the createObject call might throw an exception,
            // so catch all, not just PDOExceptions
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
    }

    public function get($id){
        // create generic sql query
        $sql = 'SELECT ' . $this->getTable() . '.*, ' . $this->getJoinTable() .'.part_number FROM ' .
                $this->getCompoundTable() . ' WHERE ' . $this->getTable() . '.id = ?';
        try{
            $stmt = $this->con->prepare($sql);
            // bind the index paramater
            $stmt->bindValue(1, $id, \PDO::PARAM_INT);
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

    public function getPartIdFromPartNo($partNo) {
        // defer to part provider
        return $this->partService->getPartIdFromPartNo($partNo);
    }

}
