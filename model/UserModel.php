<?php

namespace app\model;

use app\core\Application;
use app\core\Database;

class UserModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }


    /**
     * Method searches for user email in db.
     * 
     * @param $email
     * @return bool
     */
    public function findUserByEmail($email)
    {
        // check if the given email is in data base
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE `email` = :email");

        // add values to statment
        $this->db->bind(':email', $email);

        // save result in $row
        $row = $this->db->singleRow();

        // check if we got some results
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Method registers new user.
     * 
     * @param $data
     * @return bool
     */
    public function register($data)
    {
        // prepare statment
        $this->db->query("INSERT INTO users (`name`, `surname`, `email`, `password`, `phone`, `address`) VALUES (:name, :surname, :email, :password, :phone, :address)");

        // add values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':surname', $data['surname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['number']);
        $this->db->bind(':address', $data['address']);
        // hashed
        $this->db->bind(':password', $data['password']);

        // make query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Method logins user in.
     * 
     * @param $email
     * @param $notHashedPass
     * @return false|mixed
     */
    public function login($email, $notHashedPass)
    {
        // get the row whith given email
        $this->db->query("SELECT * FROM users WHERE `email` = :email");

        $this->db->bind(':email', $email);

        $row = $this->db->singleRow();

        if ($row) {
            $hashedPassword = $row->password;
        } else {
            return false;
        }

        // check password
        if (password_verify($notHashedPass, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }


    /**
     * Method searches for users in db by id.
     * 
     * @param $id
     * @return false|mixed
     */
    public function getUserById($id)
    {
        $this->db->query("SELECT name, email FROM users WHERE id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->singleRow();

        if ($this->db->rowCount() > 0) return $row;
        return false;
    }
}