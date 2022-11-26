<?php
session_start();

// importing necessary files
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/core/general_functions.php");
require_once($root_dir . "/classes/user_db_handle.php");

if (isset($_POST["csrf_token"]) && validateCsrfToken($_POST["csrf_token"])) {
    $user_db_handle = new user_db_handle();

    // delete all files and folder of user in uploads
    $files = $user_db_handle->get("SELECT location, name FROM uploads WHERE user = ?", "i", $_SESSION["userId"]);
    $location = "";

    while ($file = $files->fetch_assoc()) {
        $location = $file["location"];

        $filename = $location . "/" . $file["name"];

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    // delete the folder
    if ($location && is_dir($location)) {
        if (rmdir($location)) {
            // deleting user
            $isDeleted = $user_db_handle->deleteAccount($_SESSION["userId"]);

            if ($isDeleted) {
                $_SESSION = array();
                echo 0;
            } else {
                echo 3; // unable to delete account and user data for some reason
            }
        } else {
            echo 2; // unable to delete directory
        }
    }
} else {
    echo 1; /// invalid or no csrf token
}
