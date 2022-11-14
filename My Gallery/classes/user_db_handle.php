<?php
// including necessary files
$root_path = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_path . "/core/db_class.php");
require_once($root_path . "/core/general_functions.php");

class user_db_handle extends db_class{
    
    /**
     * function to register user
     * @param string $username username of registering user
     * @param string $email email of registering user
     * @param string $password password of registering user
     * @return bool true on success, false otherwise
     */
    function registerUser($username, $email, $password){
        // hashing password
        $password = hashPassword($password);

        // creating query and format
        $query = "INSERT INTO users VALUES (NULL, ?, ?, ?)";
        $format = "sss";

        $result = $this->insert($query, $format, $username, $email, $password);

        if($result){
            return $result;
        }
        else{
            return false;
        }
    }

    /**
     * function to check if user with $email already exists
     * @param string $email
     * @return bool true if user exists, false otherwise
     */
    function checkForUser($email){
        // creating query and format
        $query = "SELECT * FROM users WHERE email = ?";
        $format = "s";

        $result = $this->get($query, $format, $email);

        if($result){
            if($result->num_rows === 0){
                return false;
            }
            else{
                return true;
            }
        }

        return true; // true returned if there was an error quering the database
    }
}