<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use App\Model\Customer;

/**
 * Description of CustomerService
 *
 * @author davethemac
 */
class CustomerService extends AbstractObjectService{

    protected function createObject(array $data){
        return new Customer($data);
    }

    public function persist($object){

        // build sql
        if($object->getId()){
            $sql = 'UPDATE ' . $this->getTable() . ' SET customer_name = :name WHERE id = :id';
        }else{
            $sql = 'INSERT INTO ' . $this->getTable() . '(customer_name) VALUES(:name)';
        }

        // prepare statement
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':name', $object->getName(), \PDO::PARAM_STR);
            $stmt->execute();
            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }
        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }
    }

    public function addTestCustomers(){
        $customers[] = $this->createObject(array('customer_name' => 'Sunny Meadows'));
        $customers[] = $this->createObject(array('customer_name' => 'Leafy Pasture'));
        $customers[] = $this->createObject(array('customer_name' => 'Muddy Fields'));
        foreach($customers as $customer){
            $this->persist($customer);
        }
    }

}
