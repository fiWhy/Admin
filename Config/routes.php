<?php
    require CAKE . 'Config' . DS . 'routes.php';
    
    Router::connect('/admin/users', ['controller' => 'admin_users', 'action' => 'index']);
