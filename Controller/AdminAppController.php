<?php
/**
 * Admin App Controller
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

App::uses('AppController', 'Controller');

class AdminAppController extends AppController
{
    public $components = [
        'Auth' => [
            'loginAction' => [
                'controller' => 'users',
                'action' => 'login',
                'plugin' => 'admin'
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                'userModel' => 'User'
                ]
            ],
            'authError' => 'Did you really think you are allowed to see that?'
        ], 'Session', 'RequestHandler', 'Paginator'
    ];
    
    public $helpers = array( 'Session', 'Html', 'Form');
    
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
    }
    
    public function beforeRender()
    {
        parent::beforeRender();
    }

    public function prepareForDatatable($model)
    {
        $this->loadModel($model);

        $data = $this->request->data;


        /**
         * Conditions
         */

        $conditions = [];


        $order = [
            $model.'.'.$data['columns'][$data['order'][0]['column']]['data'] => $data['order'][0]['dir']
        ];


            /**
             * Searching and found
            */
            $searchableFields = ['User.id'];

            $conditions['or'] = [];
            $search = false;
            if(!empty($data['search']['value']))
                $search = true;
            foreach ($data['columns'] as $k => $column) {

                $searchableFields[$k+1] = $model.'.'.$column['data'];

                /**
                 * Make search if searchable
                 */
                if ($column['searchable'] == 'true' && $search) {
                    $conditions['or'][] = [$model.'.'.$column['data'].' like' => '%'.$data['search']['value'].'%'];

                    if(!empty($columns['search']['value']))
                        $conditions['or'][] = [$model.'.'.$column['data'].' like' => '%'.$column['search']['value'].'%'];
                }

            }

        $this->sendAjax($conditions);

        $this->Paginator->settings = [
            'limit' => $data['length'],
            'fields' => $searchableFields,
            'page' => $data['start'],
            'order' => $order,
            'conditions' => $conditions
        ];


        $count = $this->$model->find('count', [
            'conditions' => $conditions
        ]);

        $items = [];

        foreach($this->Paginator->paginate($model) as $key => $field){
            $items[] = $field[$model];
        }

        return [
            "draw" => $data['draw'],
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            'data' => $items
        ];
    }
    
    public function sendAjax(array $data)
    {
        $this->response->type('json');
        $this->response->statusCode('200');

        $this->response->body(json_encode($data));
        $this->response->send();
        $this->_stop();
    }
    
}
