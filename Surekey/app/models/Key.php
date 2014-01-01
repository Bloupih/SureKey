<?php

class Key extends Eloquent{


    protected $table = 'keys';


    public function getId(){
        return $this->id;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($value){
        $this ->content = $value;
    }

    public function getAccountid(){
        return $this->accountid;
    }

    public function setAccountId($value){
        $this ->accountid = $value;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($value){
        $this ->status = $value;
    }

    public function getDeviceid(){
        return $this->deviceid;
    }

    public function setDeviceid($value){
        $this->deviceid = $value;
    }

}