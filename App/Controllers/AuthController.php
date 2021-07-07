<?php
  namespace App\Controllers;

  use MF\Controller\Action;
  use MF\Model\Container;

  class AuthController extends Action{
    public function authenticateUser(){
      $user = Container::getModel('User');
      $user->__set('email', $_POST['email']);
      $user->__set('password', $_POST['password']);
      $user->authenticateUser();
      if($user->__get('id') != '' && $user->__get('name')){
        echo 'Authenticated';
      }else{
        echo 'Authentication Error';
        header('Location: /?login=error');
      }
    }
  }
?>