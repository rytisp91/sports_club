<?php

namespace app\model;

use app\core\Application;
use app\core\Database;

class CommentModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function getComments()
    {
        // prepare statement
        $this->db->query("SELECT * FROM comment ORDER BY created_at ASC");

        // save result in $row
        $row = $this->db->resultSet();

        // check if we got any results
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    public function addComment($author, $commentBody)
    {
        // get data and add comment using data
        $this->db->query("INSERT INTO `comment` (`author`, `comment_body`) VALUES (:author, :comment_body)");

        // bind the values
        $this->db->bind(':author', $author);
        $this->db->bind(':comment_body', $commentBody);

        // make query 
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
