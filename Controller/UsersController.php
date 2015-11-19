<?php
App::uses('AdminAppController', 'Admin.Controller');

class UsersController extends AdminAppController {
    
    public function beforeRender()
    {
        parent::beforeRender();

        $this->layout = 'login';

    }

    function login() {
        if ($this->request->is('post')) {
            if($this->Auth->login()) {
                return $this->redirect('/admin');
            } else {
                $this->Session->setFlash('Wrong login or password');
            }
        }
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }

}
