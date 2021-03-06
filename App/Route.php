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

      $routes['timeline'] = array(
        'route' => '/timeline',
        'controller' => 'AppController',
        'action' => 'handleTimeline'
      );

      $routes['logout'] = array(
        'route' => '/logout',
        'controller' => 'AuthController',
        'action' => 'logout'
      );

      $routes['tweet'] = array(
        'route' => '/tweet',
        'controller' => 'AppController',
        'action' => 'tweet'
      );

      $routes['follow'] = array(
        'route' => '/follow',
        'controller' => 'AppController',
        'action' => 'follow'
      );

      $routes['action'] = array(
        'route' => '/action',
        'controller' => 'AppController',
        'action' => 'action'
      );
      $routes['deletetweet'] = array(
        'route' => '/delete',
        'controller' => 'AppController',
        'action' => 'deleteTweet'
      );
      
      
      $this->setRoutes($routes);
    }
  }
?>