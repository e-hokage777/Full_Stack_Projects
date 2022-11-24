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
        $query = "INSERT INTO users VALUES (NULL, ?, ?, ?, 0)";
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

    /**
     * function to verify user
     * @param int id the id of the request
     * @return bool true on success, false otherwise
     */
    function activateUserAccount($id){
        $query = "UPDATE users SET active = 1 WHERE id = ?";

        $res = $this->makeQuery($query, "i", $id);

        return $res;
    }

    /**
     * function to insert upload details into database
     * @param int $id the user's id
     * @param string $title title of the art
     * @param string $description description about the art
     * @param string $location where the art should be stored in file truee
     * @param string $time_uploaded when the art was uploaded
     */
    function uploadArt($id, $title, $description, $name, $location){
        $query = "INSERT INTO uploads (user, title, description, name, location) VALUES (?, ?, ?, ?, ?)";
        $format = "issss";

        $insert_id = $this->insert($query, $format, $id, $title, $description, $name, $location);

        if($insert_id){
            return $insert_id;
        }
        else{
            return false;
        }
    }
}