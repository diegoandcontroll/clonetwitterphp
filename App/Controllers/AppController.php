<?php
  namespace App\Controllers;
  use MF\Controller\Action;
  use MF\Model\Container;
  class AppController extends Action{

    public function handleTimeline(){
      session_start();
      $isAuthenticated = $this->verifySession('id', 'name');
      if($isAuthenticated){
        $tweet = Container::getModel('Tweet');
        $tweets = $tweet->getTweets($_SESSION['id']);
        $this->view->tweets = $tweets;
        $this->render('timeline');
      }else{
        header('Location: /?login=error');
      }
    }

    public function tweet(){
      session_start();
      $isAuthenticated = $this->verifySession('id', 'name');
      if($isAuthenticated){
        $tweet = Container::getModel('Tweet');
        $tweet->__set('tweet', $_POST['tweet']);
        $tweet->__set('user_id', $_SESSION['id']);
        $tweet->saveTweet();
        header('Location: /timeline');
      }else{
        header('Location: /?login=error');
      }
      
    }

    
  }
?>