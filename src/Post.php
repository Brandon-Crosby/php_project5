<?php
namespace App;
use \PDO;

class Post
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

//Get Entry
    public function getPost($id)
    {
        $results = $this->db->prepare('SELECT * FROM posts WHERE id=:id' );
        $results->bindParam('id', $id);
        $results->execute();
        $post = $results->fetch();
        return $post;

    }

//Get All Entries
    public function getPosts()
    {
        $results = $this->db->prepare(
            'SELECT * FROM posts ORDER BY date DESC'
        );
        $results->execute();
        return $results->fetchAll(PDO :: FETCH_ASSOC);
        return $post;
    }

//Create Post
    public function createPost($title, $date, $body)
    {
        $results = $this->db->prepare('INSERT INTO posts (title, date, body) VALUES (:title, :date, :body)');
        $results->bindParam(':title', $title, PDO::PARAM_STR);
        $results->bindParam(':date', $date, PDO::PARAM_STR);
        $results->bindParam(':body', $body, PDO::PARAM_STR);
        $results->execute();
        return true;
    }
//Edit Post
    public function updatePost($id, $title, $date, $body)
    {
        $results = $this->db->prepare('UPDATE posts SET title=:title, date=:date, body=:body WHERE id=:id');
        $results->bindParam(':id', $id, PDO::PARAM_INT);
        $results->bindParam(':title', $title, PDO::PARAM_STR);
        $results->bindParam(':date', $date, PDO::PARAM_STR);
        $results->bindParam(':body', $body, PDO::PARAM_STR);
        $results->execute();
        return true;
    }
}
