<?php
    
    Router::connect('/admin/users', array('controller' => 'admin_users', 'plugin' => 'admin', 'action' => 'index'));
    
/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
    require CAKE . 'Config' . DS . 'routes.php';