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
        $user = Container::getModel('User');
        $this->view->totalTweets = $user->getTotalTweets($_SESSION['id']);
        $this->view->totalFollowing = $user->getTotalFollowing($_SESSION['id']);
        $this->view->totalFollowers = $user->getTotalFollow($_SESSION['id']);
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

    public function follow(){
      session_start();
      $isAuthenticated = $this->verifySession('id', 'name');
      $users = array();
      if($isAuthenticated){
        $followUs = isset($_GET['followUs']) ? $_GET['followUs'] : '';
        $user = Container::getModel('User');
        if($followUs != ''){
          $user->__set('name', $followUs);
          $user->__set('id', $_SESSION['id']);
          $users = $user->getAllUsers();
        }
        $this->view->username = $_SESSION['name'];
        $this->view->users = $users;
        $this->view->totalTweets = $user->getTotalTweets($_SESSION['id']);
        $this->view->totalFollowing = $user->getTotalFollowing($_SESSION['id']);
        $this->view->totalFollowers = $user->getTotalFollow($_SESSION['id']);
        $this->render('follow');
      }else {
        header('Location: /?login=error');
      }
    }

    public function action(){
      session_start();
      $isAuthenticated = $this->verifySession('id', 'name');
      if($isAuthenticated){
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $user_following = isset($_GET['user_id']) ? $_GET['user_id']: '';

        $user = Container::getModel('User');
        $user->__set('id', $_SESSION['id']);

        if($action == 'follow'){
          $user->follow($user_following);
        }else if($action == 'unfollow'){
          $user->unfollow($user_following);
        }
      }
    }

    public function deleteTweet(){
      session_start();
      $isAuthenticated = $this->verifySession('id', 'name');
      if($isAuthenticated){
        $tweet = Container::getModel('Tweet');
        $tweet->deleteTweetUser($_POST['id_user'],$_POST['id_tweet']);
        header('Location: /timeline');
      }
    }

    
  }
?>