<?php

namespace app\models;

use core\Database;

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function addComment($data)
    {
        $this->db->query('INSERT INTO comments (user_id, author, comment_body) VALUES (:user_id, :author, :comment_body)');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':author', $data['username']);
        $this->db->bind(':comment_body', $data['commentBody']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getComments()
    {
        $sql = "SELECT * FROM comments";

        $this->db->query($sql);
        
        $result = $this->db->resultSet();

        return $result;
    }

    public function getUsername($id)
    {
        $this->db->query("SELECT name, lastname FROM users WHERE user_id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->singleRow();

        if ($this->db->rowCount() > 0) return $row;
        return false;
    }
}