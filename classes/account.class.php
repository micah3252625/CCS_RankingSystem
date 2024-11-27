<?php

require_once 'database.class.php';

class Account
{
    public $id = '';

    public $user_id = null; // Reference to the user (student, staff, admin)
    public $username = '';

    public $password = '';

    public $role_id = null;


    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Store a new account in the database
     * 
     * @param int $user_id The ID of the user (student, staff, admin)
     * @return bool True on success, False on failure
     */
    public function store($user_id)
    {
        // Check if username already exists
        if ($this->usernameExist($this->username)) {
            throw new Exception("Username already exists.");
        }

        // Hash the password
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert account into the database
        $sql = "INSERT INTO account ( user_id, username, password, role_id) 
                VALUES (:user_id, :username, :password, :role_id)";
        $query = $this->db->connect()->prepare($sql);

        // Bind parameters
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':password', $hashedPassword);
        $query->bindParam(':role_id', $this->role_id);

        // Execute query
        return $query->execute();
    }

    /**
     * Check if a username already exists
     */
    function usernameExist($username)
    {
        $sql = "SELECT COUNT(*) FROM account WHERE username = :username";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);
        $query->execute();
        return $query->fetchColumn() > 0;
    }

    /**
     * Check if an email already exists
     */
    function emailExist($email)
    {
        $sql = "SELECT COUNT(*) FROM user WHERE email = :email";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        return $query->fetchColumn() > 0;
    }
}
