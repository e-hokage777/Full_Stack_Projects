<?php
session_start();

// importing necessary files
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";

require_once($root_dir . "/core/config.php");
require_once($root_dir . "/core/general_functions.php");
require_once($root_dir . "/classes/user_db_handle.php");

print_r($_FILES);
$errors = [];

if (isset($_POST["csrf_token"]) && validateCsrfToken($_POST["csrf_token"])) {


    if (isset($_FILES["gallery-file"])) {
        $file = $_FILES["gallery-file"];

        if ($file["error"] === 0) {
            if (checkFileSize($file, MAX_FILE_SIZE)) {
                if (checkFileType($file, "image/jpeg", "image/png")) {
                    // get user name from database
                    $user_db_handle = new user_db_handle();
                    $user = $user_db_handle->get("SELECT username FROM users WHERE id = ?", "i", $_SESSION["userId"]);

                    if ($user && $user->num_rows === 1) {
                        $user = $user->fetch_assoc();

                        $target_dir = UPLOAD_DIR . $user["username"];

                        if (!is_dir($target_dir)) {
                            mkdir($target_dir);
                        }

                        // saving file to the directory
                        if(move_uploaded_file($file["tmp_name"], $target_dir . "/" .basename($file["name"]))){
                            // create entry in database
                        }
                        else{
                            $errors[] = 7;
                            echo "file not uploaded";
                        }

                    } else {
                        $errors[] = 6; // no such user exists
                    }
                } else {
                    $errors[] = 5; // invalid file type
                }
            } else {
                $errors[] = 4; // file size too large
            }
        } else {
            $errors[] = 3; // error uploading file
        }
    } else {
        $errors[] = 2; // no file selected
    }
} else {
    $errors[] = 1; // csrf_token not set
}



function checkFileSize($file, $size)
{
    if ($file["size"] < $size) {
        return true;
    } else {
        return false;
    }
}

function checkFileType($file, ...$types)
{
    if (in_array($file["type"], $types)) {
        return true;
    } else {
        return false;
    }
}


echo json_encode($errors);
