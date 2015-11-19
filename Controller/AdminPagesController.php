<?php
App::uses('AdminAppController', 'Admin.Controller');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminPagesController
 *
 * @author denis
 */
class AdminPagesController extends AdminAppController{
    
    public function dashboard()
    {
        $this->render('../Layouts/dashboard');
    }
}
