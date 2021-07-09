<?php
  namespace App\Models;

  use MF\Model\Model;

  class Tweet extends Model{
    private $id;
    private $user_id;
    private $tweet;
    private $date;

    public function __get($attr){
      return $this->$attr;
    }

    public function __set($attr, $value){
      $this->$attr = $value;
    }

    public function saveTweet(){
      $query = 'insert into tweets(id_usuario,tweet)values(:user_id, :tweet)';
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':user_id', $this->__get('user_id'));
      $stmt->bindValue(':tweet', $this->__get('tweet'));
      $stmt->execute();
      return $this;
    }

    public function getTweets($id_user){
      $query = "
      select
        t.id, t.tweet, t.id_usuario, u.nome, DATE_FORMAT(t.data, '%d/%m%Y% %H:%i') as data 
      from 
        tweets as t
        left join usuarios as u on(t.id_usuario = u.id)
      where t.id_usuario = ".$id_user."
      or t.id_usuario in (select id_usuario_seguindo from usuarios_seguidores where id_usuario = ". $id_user.") order by t.data desc";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteTweetUser($id,$idTweet){
      $query = "delete from tweets where id_usuario = ".$id." and id = ".$idTweet;
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $this;
    }
  }
?>