<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Provider;

use App\Model\Part;
use App\Validator\ChoiceInterface;

/**
 * Description of PartProvider
 *
 * @author david.mccart
 */
class PartProvider extends AbstractObjectProvider implements ChoiceInterface{
    
    protected function createObject(array $data) {
        return new Part($data);
    }

    public function persist($object) {
        
        // build sql
        if($object->getId()){
            $sql = 'UPDATE ' . $this->getTable() . ' SET part_number = :part_number, description = :description WHERE id = :id';
        }else{
            $sql = 'INSERT INTO ' . $this->getTable() . '(part_number, description) VALUES(:part_number, :description)';
        }
     
        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':part_number', $object->getPartNumber(), \PDO::PARAM_STR);
            $stmt->bindValue(':description', $object->getDescription(), \PDO::PARAM_STR);
            $stmt->execute();
            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }
        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
        
    }
        
    public function addTestParts(){
        $parts[] = $this->createObject(array('part_number' => '01', 'description' => 'Widget'));
        $parts[] = $this->createObject(array('part_number' => '02', 'description' => 'Dongle'));
        $parts[] = $this->createObject(array('part_number' => '03', 'description' => 'Geegaw'));
        $parts[] = $this->createObject(array('part_number' => 'A01', 'description' => 'Advanced Widget'));
        $parts[] = $this->createObject(array('part_number' => 'A02', 'description' => 'Advanced Dongle'));
        $parts[] = $this->createObject(array('part_number' => 'A03', 'description' => 'Advanced Geegaw'));
        $parts[] = $this->createObject(array('part_number' => 'M01', 'description' => 'Modified Widget'));
        $parts[] = $this->createObject(array('part_number' => 'M02', 'description' => 'Modified Dongle'));
        $parts[] = $this->createObject(array('part_number' => 'M03', 'description' => 'Modified Geegaw'));
        foreach($parts as $part){
            $this->persist($part);
        }
    }

    public function getChoices(){
        $parts = $this->getAll();
        $choices = array();
        foreach($parts as $part){
            $choices[] = $part->getPartNumber();
        }
        return $choices;
    }

    public function getPartIdFromPartNo($partNo) {
                // create generic sql query
        $sql = 'SELECT id FROM ' . $this->getTable() . ' WHERE part_number = :part_number';
        try{
            $stmt = $this->con->prepare($sql);
            // bind the index paramater
            $stmt->bindValue(':part_number', $partNo, \PDO::PARAM_STR);
            if($stmt->execute()===false){
                // throws an exception in debug mode
                // do some kind of error handling...
                return false;
            }
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data===false){
                // throws an exception in debug mode
                // do some other kind of error handling
                return false;
            }
            # THIS MIGHT NOT BE ENOUGH CHECKING, TEST BY FORCING A NOT FOUND RESULT
            // for the result, create an object and stuff it with data
            // we don't know what kind of object to create
            return $data['id'];
            
        } catch (\Exception $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

}
