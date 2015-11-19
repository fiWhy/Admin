<?php
/**
 * User Model
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
 *
 * @author     Yusuf Abdulla Shunan <shunan@maldicore.com>
 * @copyright  Copyright 2012, Maldicore Group Pvt Ltd. (http://maldicore.com)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @since      CakePHP(tm) v 2.1.1
 */
class User extends AppModel {
    public $useTable = 'users';
    public $validate = array(
        'old_password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field can not be empty'
             ),
            'matchPassword' => array(
                'rule' => array('validateMatchPassword'),
                'message' => 'Password not match'
             ),
        ),
        'new_password' => array(
            'notEmpty' => array(
                'rule' =>  array('notEmpty'),
                'message' => 'This field can not be empty'
            ),
            'alphaNumeric' => array(
                'rule' => array('notEmpty'),
                'required' => true,
                'message' => 'Only letters and integers, min 3 characters'
            ),
        ),
        'confirm_password' => array(
            'rule' => array('validateConfirmPassword'),
            'message' => 'Passwords do not match'
        )
    );
    /**
     * @var string admin name
     */
    private $userName = 'admin';

    /**
     * Match old passwords validation
     * @return bool
     */
    
    public function beforeSave($options = array()) {
        $this->data["User"]["password"] = AuthComponent::password($this->data["User"]["password"]);
    }

    public function validateMatchPassword()
    {
        $adminUser = $this->findByUsername($this->userName);
        $password = $adminUser['User']['password'];
        return AuthComponent::password($this->data['User']['old_password'])  == $password;
    }
    /**
     * Match passwords validation
     * @return bool
     */
    public function validateConfirmPassword()
    {
        return $this->data['User']['new_password'] == $this->data['User']['confirm_password'];
    }

    public function savePassword($data)
    {
        $adminUser = $this->findByUsername($this->userName);
        $this->id = $adminUser['User']['id'];
        $data['User']['password'] = AuthComponent::password($data['User']['new_password']);
       return $this->save($data);

    }
}
?>