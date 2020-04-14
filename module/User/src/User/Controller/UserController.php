<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Auth\Form\RegistrationForm;
use Auth\Form\RegistrationFilter;

use User\Model\User;
use User\Model\UserTable;
use User\Form\UserForm;


class UserController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function addAction()
    {
        ini_set("error_reporting", E_ALL);
        echo "hiii 28";
        // exit;
//        $form = new UserForm();
//        exit;
//        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
//        echo "<pre>";
//        print_r($request->getPost());
//        exit;
        if ($request->isPost()) {
            $User = new UserTable();
            $User->saveUser($request->getPost());

            $this->sendConfirmationEmail($User);

            return $this->redirect()->toRoute('user');
        }
        return new ViewModel();

    }



    public function dashboardAction()
    {
//        $user_session = new Container('user');
//        $userid = $user_session->userid;
        $User = new UserTable();
        $result = $User->getexchangerates(1);
        return new viewModel(array('exchangelist'=>$result));

    }

    public function loginAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $sm = $this->getServiceLocator();
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

            $config = $this->getServiceLocator()->get('Config');

            $authAdapter = new AuthAdapter($dbAdapter,
                'tbl_user', // there is a method setTableName to do the same
                'username', // there is a method setIdentityColumn to do the same
                'password', // there is a method setCredentialColumn to do the same
                "MD5(password) AND active_status = 1" // setCredentialTreatment(parametrized string) 'MD5(?)'
            );
            $authAdapter
                ->setIdentity($request->getPost()->emailid)
                ->setCredential($request->getPost()->password)
            ;

            $auth = new AuthenticationService();
            $result = $auth->authenticate($authAdapter);
            if($result == SUCCESS){
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(
                    null,
                    'password'
                ));
                $user_session = new Container('user');
                $user_session->userid = $result['id'];
                return $this->redirect()->toRoute('dashboard');
            }else{
                return $this->redirect()->toRoute('login');
            }
        }
        return new ViewModel();
    }
}