<?php
  namespace App\Controllers;
  use MF\Controller\Action;
  use MF\Model\Container;
  class AppController extends Action{

    public function handleTimeline(){
      session_start();
      $id = $_SESSION['id'];
      $name = $_SESSION['name'];

      if($name != '' && $id != ''){
        $this->render('timeline');
      }else{
        header('Location: /?login=error');
      }
    }
  }
?>