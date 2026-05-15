<?php
class User{
    private $id;
    private $name;
    private $email;
    private $role_id;
    public function __construct($name,$email,$role_id)
    {
       $this->name=$name;
       $this->email=$email;
       $this->role_id=$role_id;
    }
    public function setId($newid){
           $this->id=$newid;
    }
    public function getRole(){
        return $this->role_id;
    }
    public function getName(){
        return $this->role_id;
    }
    public function getEamil(){
        return $this->email;
    }
    
}