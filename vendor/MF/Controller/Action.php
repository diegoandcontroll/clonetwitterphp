<?php
  namespace MF\Controller;
  use stdClass;

abstract class Action{
    protected $authenticated;
    protected $view;
    public function __construct(){
      $this->view = new stdClass();
    }

    protected function render($view, $layout = 'layout'){
      $this->view->page = $view;
      if(file_exists("../App/Views/".$layout.".phtml")){
        require_once "../App/Views/".$layout.".phtml";
      }else{
        $this->content();
      }
    }
    public function verifySession($id, $name){
      if($_SESSION[$id] != '' && $_SESSION[$name] != ''){
        $this->authenticated = true;
      }else{
        $this->authenticated = false;
      }
      return $this->authenticated;
    }
    protected function content(){
      $currentClass = get_class($this);
      $currentClass = str_replace('App\\Controllers\\', '', $currentClass);
      $currentClass = strtolower(str_replace('Controller', '', $currentClass));
      require_once "../App/Views/".$currentClass."/".$this->view->page.".phtml";
    }
  }
?>