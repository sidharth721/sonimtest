<?php
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import


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
        $this->emailid = (isset($data['emailid'])) ? $data['emailid'] : null;
        $this->phonenumber  = (isset($data['phonenumber'])) ? $data['phonenumber'] : null;
        $this->address  = (isset($data['address'])) ? $data['address'] : null;
        $this->prooftype  = (isset($data['prooftype'])) ? $data['prooftype'] : null;
        $this->filepath  = (isset($data['filepath'])) ? $data['filepath'] : null;
        $this->status  = (isset($data['status'])) ? $data['status'] : null;
        $this->created_date  = (isset($data['created_date'])) ? $data['created_date'] : null;
        $this->updated_date  = (isset($data['updated_date'])) ? $data['updated_date'] : null;
        $this->username  = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password'])) ? $data['password'] : null;
    }


    // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'artist',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}