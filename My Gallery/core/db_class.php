<?php
// importing configuration file
$root_path = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_path . "/core/config.php");

class db_class
{
    function __construct()
    {
        $this->conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Error connecting to database: " . $this->conn->connect_error);
        }
    }

    // closing connection on object destruction
    function __destruct()
    {
        $this->conn->close();
    }

    // function to insert into database
    function insert($query, $format, ...$values)
    {
        $stmt = $this->conn->prepare($query);

        if ($format) {
            $stmt->bind_param($format, ...$values);
        }

        if ($stmt->execute()) {
            if ($stmt->insert_id) {
                return $stmt->insert_id;
            }

            return true;
        } else {
            return false;
        }

        $stmt->free_result();
        $stmt->close();
    }

    function get($query, $format, ...$values){
        $stmt = $this->conn->prepare($query);

        if($format){
            $stmt->bind_param($format, ...$values);
        }

        if($stmt->execute()){
            return $stmt->get_result();
        }
        else{
            return false;
        }

        $stmt->free_result();
        $stmt->close();
    }
}
