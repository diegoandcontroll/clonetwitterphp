<?php

namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function handleCreateAccount(){
		$this->view->user = array(
			'name' => '',
			'email' => '',
		);
		$this->view->erroRegister = false;
		$this->render('inscreverse');
	}

	public function register(){
		$user = Container::getModel('User');
		$user->__set('name', $_POST['name']);
		$user->__set('email', $_POST['email']);
		$user->__set('password', $_POST['password']);
		if($user->validateUser() && count($user->getEmailUser()) == 0){
			$user->saveUser();
			$this->render('cadastro');
		}else{
			$this->view->user = array(
				'name' => $_POST['name'],
				'email' => $_POST['email'],
			);
			$this->view->erroRegister = true;
			$this->render('inscreverse');
		}
		
	}

}


?>