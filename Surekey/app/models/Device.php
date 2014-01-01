<?php

class Device extends Eloquent{

    // function Create extends from Eloquent. (Device::Create(array(...));

    protected $table = 'devices';

    public function getId(){

        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getDevice(){
        return $this->device;
    }

    public function setDevice($value){
        $this->device=$value;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $description == null ? $description = "Pas de description" : null;
        $this->description = $description;
    }

    public function getUserId(){
        return $this->userid;
    }

    public function setUserId($userId){
        $this->userid=$userId;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($password){
        $this->password=$password;
    }
}
