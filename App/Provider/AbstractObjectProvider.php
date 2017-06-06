<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Provider;

/**
 * Description of AbstractObjectProvider
 *
 * @author david.mccart
 */
abstract class AbstractObjectProvider {

    /** @var \PDO */
    protected $con; // to hold the db connection
    protected $table; // to hold the name of the table
    
    public function __construct(\PDO $con, $table) {
        
        $this->con = $con;
        $this->table = $table;
    }
    
    public function getAll(){
        // create generic sql query
        $sql = 'SELECT * FROM ' . $this->getTable();
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
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE id = ?';
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
    
    protected function getTable() {
        return $this->table;
    }
    
    // just return a new object of whatever type we need
    abstract protected function createObject(array $data);
    
    // for the given object, persist all its persistent properties to some database table
    abstract public function persist($object);
}
