<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of User
 *
 * @author david.mccart
 */
class User implements UserInterface{

    private $id;
    private $username;
    private $password;
    private $roles;

    public function __construct($username, $password = null, $id = null, array $roles = array())
    {
        if ('' === $username || null === $username) {
            throw new \InvalidArgumentException('The username cannot be empty.');
        }
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = (int)$id;
        return $this;
    }
    
    public function getRoles()
    {
        return $this->roles;
    }    

    public function getSalt()
    {
    }
    
    public function getUsername()
    {
        return $this->username;
    }
        
    public function eraseCredentials()
    {
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }

}
