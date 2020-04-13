<?php
namespace User\Model;

class User
{
    public $id;
    public $emailid;
    public $phonenumber;
    public $address;
    public $prooftype;
    public $filepath;
    public $status;
    public $created_date;
    public $updated_date;
    public $username;
    public $password;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->artist = (isset($data['emailid'])) ? $data['emailid'] : null;
        $this->title  = (isset($data['phonenumber'])) ? $data['phonenumber'] : null;
        $this->title  = (isset($data['address'])) ? $data['address'] : null;
        $this->title  = (isset($data['prooftype'])) ? $data['prooftype'] : null;
        $this->title  = (isset($data['filepath'])) ? $data['filepath'] : null;
        $this->title  = (isset($data['status'])) ? $data['status'] : null;
        $this->title  = (isset($data['created_date'])) ? $data['created_date'] : null;
        $this->title  = (isset($data['updated_date'])) ? $data['updated_date'] : null;
        $this->title  = (isset($data['username'])) ? $data['username'] : null;
        $this->title  = (isset($data['password'])) ? $data['password'] : null;
    }
}