<?php
App::uses('AdminAppController', 'Admin.Controller');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminUsersController
 *
 * @author denis
 */
class AdminUsersController extends AdminAppController{
    
    
    public function beforeRender(){
        parent::beforeRender();
        $this->set('boxBig', 'Users side');
        $this->set('boxMore', 'redact users information');
    }
    
    public function index()
    {
        $this->set([
            'boxTitle' => 'Users list'
        ]);
    }
    
    public function getUsers()
    {
        $this->sendAjax($this->prepareForDatatable('User'));
    }
}
