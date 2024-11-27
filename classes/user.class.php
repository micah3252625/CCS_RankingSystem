<?php

require_once 'database.class.php';

class User
{
    public $id = '';

    public $identifier = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $username = '';
    public $course = '';
    public $department = '';
    public $email = '';
    public $password = '';
    public $role_id = null;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }
    public function store()
    {
        try {
            $sql = "INSERT INTO user (role_id, identifier, firstname, middlename, lastname, email, course, department) 
                    VALUES (:role_id, :identifier, :firstname, :middlename, :lastname, :email, :course, :department)";

            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':role_id', $this->role_id, PDO::PARAM_INT);
            $query->bindParam(':identifier', $this->identifier, PDO::PARAM_STR);
            $query->bindParam(':firstname', $this->first_name, PDO::PARAM_STR);
            $query->bindParam(':middlename', $this->middle_name, PDO::PARAM_STR);
            $query->bindParam(':lastname', $this->last_name, PDO::PARAM_STR);
            $query->bindParam(':email', $this->email, PDO::PARAM_STR);
            $query->bindParam(':course', $this->course, PDO::PARAM_STR);
            $query->bindParam(':department', $this->department, PDO::PARAM_STR);

            return $query->execute();
        } catch (PDOException $e) {
            // Log the error
            error_log("Failed to store user: " . $e->getMessage());
            return false;
        }
    }
}
