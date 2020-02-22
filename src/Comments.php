<?php
namespace App;
use \PDO;

class Comments
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
  public function getComments($comment_id){
        try {
            $results = $this->db->prepare('SELECT * FROM Comments WHERE comment_id= :comment_id');
            $results->bindParam('comment_id', $comment_id, PDO::PARAM_INT);
            $results->execute();
        } catch (\Throwable $th) {
            echo $th->getMessage(), " -- line: " . $th->getLine();
        }
        return $results->fetchAll();
    }
   /**
    *
    * Get all comments
    *
    * @param integer $comment_id
    *
    * @return $comment
    */
    public function createComment($name, $body, $comment_id){
        $results = $this->db->prepare('INSERT INTO Comments(name, body, comment_id) VALUES(:name, :body, :comment_id)');
        $results->bindParam(':name', $name, PDO::PARAM_STR);
        $results->bindParam(':body', $body, PDO::PARAM_STR);
        $results->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $results->execute();
        return true;
    }
}
