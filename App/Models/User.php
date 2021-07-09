<?php
  namespace App\Models;
  use MF\Model\Model;
  class User extends Model{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __get($attr){
      return $this->$attr;
    }

    public function __set($attr, $value){
      $this->$attr = $value;
    }

    public function saveUser(){
      $query = 'insert into usuarios (nome,email,senha) values(:name, :email, :password)';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':name', $this->__get('name'));
      $stmt->bindValue(':email', $this->__get('email'));
      $stmt->bindValue(':password', $this->__get('password'));
      $stmt->execute();
      return $this;
    }

    public function validateUser(){
      $valid = true;
      if(strlen($this->__get('name')) < 3){
        $valid = false;
      }

      if(strlen($this->__get('email')) < 5){
        $valid = false;
      }

      if(strlen($this->__get('password')) < 3){
        $valid = false;
      }

      return $valid;
    }

    public function getEmailUser(){
      $query = 'select nome, email from usuarios where email = :email';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':email', $this->__get('email'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function authenticateUser(){
      $query = 'select id, nome, email from usuarios where email = :email and senha = :password';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':email', $this->__get('email'));
      $stmt->bindValue(':password', $this->__get('password'));
      $stmt->execute();
      $user = $stmt->fetch(\PDO::FETCH_ASSOC);
      if($user['id'] != '' && $user['nome'] != ''){
        $this->__set('id', $user['id']);
        $this->__set('name', $user['nome']);
      }
      return $this;
    }

    public function getAllUsers(){
      $query = '
      select 
        u.id, u.nome, u.email, (select count(*) from usuarios_seguidores as us where us.id_usuario = :idUser and us.id_usuario_seguindo = u.id) as isFollowing
        from usuarios as u where 
        u.nome like :name and u.id != :idUser';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':name', '%'.$this->__get('name').'%');
      $stmt->bindValue(':idUser', $this->__get('id'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function follow($id_userfollowing){
      $query = '
      insert into 
        usuarios_seguidores (id_usuario, id_usuario_seguindo)
      values (:id_user, :id_userfollowing)
      ';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_user', $this->__get('id'));
      $stmt->bindValue(':id_userfollowing', $id_userfollowing);
      $stmt->execute();
      header('Location: /follow');
      return true;
      

    }

    public function unfollow($id_userfollowing){
      $query = '
      delete from 
        usuarios_seguidores where id_usuario = :id_user and id_usuario_seguindo = :id_userfollowing
      ';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_user', $this->__get('id'));
      $stmt->bindValue(':id_userfollowing', $id_userfollowing);
      $stmt->execute();
      header('Location: /follow');
      return true;
      
    }
  }
?>