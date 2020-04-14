<?php

namespace User\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getUser($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveUser(User $user)
    {
        $data = array(
            'emailid' => $user->emailid,
            'phonenumber' => $user->phonenumber,
            'address' => $user->address,
            'prooftype' => $user->prooftype,
            'username' => $user->emailid,
            'password' => md5('passw0rd')
        );

        $id = (int)$user->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $this->sendConfirmationEmail($user);
        } else {
            if ($this->getUser($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function sendConfirmationEmail($auth)
    {
        // $view = $this->getServiceLocator()->get('View');
        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();
        $this->getRequest()->getServer();  //Server vars
        $message->addTo($auth->emailid)
            ->addFrom('test@test.com')
            ->setSubject('Registration Email!')
            ->setBody("Please use the below said details for login  => Username " .$auth->emailid."
            and password as passw0rd"
                );
        $transport->send($message);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }

    public function getexchangerates($iduser){

        $adapter   = new Adapter();
        $sql       = new Sql($adapter);
        $select    = $sql->select();
        $select->from(array('CR' =>'tbl_currency_rates'),array('value as exch_rate'));
        $select->join(array('C1' => 'tbl_currency'), 'CR.from_id_currency = C1.idcurrency', array('latest_rate as currency1'));
        $select->join(array('C2' => 'tbl_currency'), 'CR.to_id_currency = C2.idcurrency', array('latest_rate as currency2'));
        $select->joinLeft(array('F' => 'tbl_favourites'), 'CR.idcurrency_rates = F.idcurrency_rates and F.iduser = '.$iduser.' and F.favuorite = 1',array('F.favourite'));
        $select->where(array('C.status' => 1));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results   = $statement->execute();
        return $results;
    }


}
