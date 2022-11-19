<?php
//starting session
session_start();


// including necessary files
$root_path = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery/";
require_once($root_path . "/classes/user_db_handle.php");
require_once($root_path . "/authenticate/verify_user.php");

$errors = []; // array to hold errors

if (!isset($_POST["csrf_token"]) || !validateCsrfToken($_POST["csrf_token"])) {
    $errors[] = 1; // csrf_token not set or invalid 
}
if (!isset($_POST["email"]) || strlen($_POST["email"]) > 100 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 2; // email not set or email format invalid
} else if (!checkdnsrr(getEmailDomain($_POST["email"]), "MX")) {
    $errors[] = 3; // invalid MX domain name
}
if (!isset($_POST["password"]) || !validatePasswordFormat($_POST["password"])) {
    $errors[] = 4; // password not set or invalid format
}

if (count($errors) === 0) {
    // connect to database
    $user_db_handle = new user_db_handle();

    // get user from the database
    // confirm password
    // confirm active

    $query = "SELECT * FROM users WHERE email = ?";

    $res = $user_db_handle->get($query, "s", $_POST["email"]);

    if($res && $res->num_rows === 1){
        $user = $res->fetch_assoc();

        if(validatePassword($_POST["password"], $user["password"])){
            if($user["active"] === 1){
                $_SESSION["isUserLoggedIn"] = true;
                $_SESSION["userId"] = $user["id"];
            }
            else{
                $errors[] = 7; // account not activated
            }
        }
        else{
            $errors[] = 6; // invalid password
        }
    }
    else{
        $errors = 5; // no such account exists
    }
}

echo json_encode($errors);
