<?php
  namespace App;
  use MF\Init\Bootstrap;

class Route extends Bootstrap{
    
    protected function initRoutes(){
      $routes['home'] = array(
        'route' => '/',
        'controller' => 'indexController',
        'action' => 'index'
      );
      $routes['create-account'] = array(
        'route' => '/create-account',
        'controller' => 'indexController',
        'action' => 'handleCreateAccount'
      );

      $routes['register'] = array(
        'route' => '/register',
        'controller' => 'indexController',
        'action' => 'register'
      );

      $routes['authenticate'] = array(
        'route' => '/authenticate',
        'controller' => 'AuthController',
        'action' => 'authenticateUser'
      );

      
      $this->setRoutes($routes);
    }
  }
?>