<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Service;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use App\Model\User;

/**
 * Description of UserService
 *
 * @author davethemac
 */
class UserService extends AbstractObjectService implements UserProviderInterface {

    private $encoder;

    public function setEncoder(PasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    // AbstractObjectService functions
    protected function createObject(array $data) {
        # possibly some of this crap could go in the actual object constructor?
        // set some default values
        $defaults = array(
            'username' => '',
            'password' => '',
            'id' => null,
            'roles' => array()
        );

        // merge the data over the defaults
        $values = array_merge($defaults, $data);

        // create the object
        return new User($values['username'], $values['password'], $values['id'], explode(',', $values['roles']));
    }

    public function persist($object) {
        // TODO: write code to store a user object in the db
        // if we have an id, first *try* to update
        // failing that, insert
        if($object->getId()){
            $sql = 'UPDATE ' . $this->getTable() . ' SET username = :username, password = :password, roles = :roles WHERE id = :id';
        }else{
            $sql = 'INSERT INTO ' . $this->getTable() . '(username, password, roles) VALUES(:username, :password, :roles)';
        }
        try{
            $stmt = $this->con->prepare($sql);
            if($object->getId()){
                $stmt->bindValue(':id', $object->getId(), \PDO::PARAM_INT);
            }
            $stmt->bindValue(':username', $object->getUsername(), \PDO::PARAM_STR);
            $stmt->bindValue(':password', $object->getPassword(), \PDO::PARAM_STR);
            $stmt->bindValue(':roles', implode(',', $object->getRoles()), \PDO::PARAM_STR);
            $stmt->execute();
            if(!$object->getId()){
                // ensure id is populated
                $object->setId($this->con->lastInsertId());
            }
        } catch (\PDOException  $ex) {
            echo $ex->getMessage() . __CLASS__ . '::' . __METHOD__ . ' in ' . __FILE__ . ': ' . __LINE__;
        }

    }

   // UserServiceInterface functions
    public function loadUserByUsername($username){
        //$this->addTestUser();
        $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE username = ?';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1, $username, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($result){
            return $this->createObject($result);
        }else{
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
    }

    public function refreshUser(UserInterface $user){
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class){
        return $class === 'Symfony\Component\Security|Core\User\User';
    }

    // dev utility functions
    protected function addDefaultTestUser() {
        // create someone to use for testing, etc
        $sql = 'INSERT INTO rr_user(username, password, roles) VALUES (?, ?, ?)';
        $stmt = $this->con->prepare($sql);

        $username = 'test';
        $roles = 'ROLE_USER';
        //$roles = 'ROLE_ADMIN';

        $encoder = new \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(13);

        $raw_password = 'test';

        $encoded_password = $encoder->encodePassword($raw_password, null);

        $stmt->bindValue(1, $username, \PDO::PARAM_STR);
        $stmt->bindValue(2, $encoded_password, \PDO::PARAM_STR);
        $stmt->bindValue(3, $roles, \PDO::PARAM_STR);
        $stmt->execute();
    }

    protected function addTestUser(){

        // given that we will need to add users, change passwords, etc
        // add are using the dependency injection thing, there has to be better ways to do it...
        //$encoder = new \Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(13);
        //$encoder = $this->app['security.default_encoder'];
        $raw_password = 'test';
        $encoded_password = $this->encoder->encodePassword($raw_password, null);

        // build an array for createObject();
        $defaults = array(
            'username' => 'test',
            'password' => $encoded_password,
            'id' => null,
            'roles' => 'ROLE_USER'
        );

        $user = $this->createObject($defaults);
        $this->persist($user);

    }

}
