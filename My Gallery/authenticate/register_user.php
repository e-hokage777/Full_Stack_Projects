<?php
//starting session
session_start();


// including necessary files
$root_path = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery/";
require_once($root_path . "classes/user_db_handle.php");

$errors = []; // array to hold errors

if (!isset($_POST["csrf_token"]) || !validateCsrfToken($_POST["csrf_token"])) {
    $errors[] = 1; // csrf_token not set or invalid 
}
if (!isset($_POST["username"]) || strlen($_POST["username"]) > 100 || !preg_match("/^[A-za-z]{2,}/", $_POST["username"])) {
    $errors[] = 2; // username not set or username format invalid
}
if (!isset($_POST["email"]) || strlen($_POST["email"]) > 100 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 3; // email not set or email format invalid
}
else if (!checkdnsrr(getEmailDomain($_POST["email"]), "MX")){
    $errors[] = 4; // invalid MX domain name
}
if (!isset($_POST["password"]) || !validatePasswordFormat($_POST["password"])) {
    $errors[] = 5; // password not set or invalid format
}
if(!isset($_POST["confirm-password"]) || ($_POST["password"] !== $_POST["confirm-password"])){
    $errors[] = 6; // passwords don't match
}

if(count($errors) === 0){
    // connect to database
    $user_db_handle = new user_db_handle();

    // check if email already exists
    if($user_db_handle->checkForUser($_POST["email"])){
        $errors[] = 7; // user already exists
    }

    else{
        $new_user_id = $user_db_handle->registerUser($_POST["username"], $_POST["email"], $_POST["password"]);

        if(!$new_user_id){
            $errors[] = 8; // error when trying to insert user
        }
    }


    // add user
}


echo json_encode($errors);
