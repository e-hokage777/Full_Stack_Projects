<?php

$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/vendor/autoload.php");
require_once($root_dir . "/core/general_functions.php");
require_once($root_dir . "/classes/user_db_handle.php");



function sendVerificationEmail($email)
{
    // connection to database
    $user_handle = new user_db_handle();

    // getting the user verification request info
    $query = "SELECT users.id, username, active, COUNT(user) AS num_tries FROM users LEFT JOIN verification_requests ON users.id = verification_requests.user AND timestamp > ? WHERE users.email = ? GROUP BY verification_requests.user";
    $oneDayAgo = time() -  (60 * 60 * 24);
    $result = $user_handle->get($query, "is", $oneDayAgo, $email);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();


        if (!$user["active"]) {
            if ($user["num_tries"] < MAX_VERIFICATION_ATTEMPTS) {
                // add another request to the database
                $hash = hashPassword(random_bytes(8));
                $hash = urlSafeEncode($hash);
                $query = "INSERT INTO verification_requests VALUES (NULL, ?, ?, ?, 0)";
                $insert_id = $user_handle->insert($query, "isi", $user["id"], $hash, time());

                if ($insert_id) {
                    // send message
                    $msg_send_res = sendMail($email, $user["username"], "Email Verification", "Click <a href='http://localhost:81/projects/My Gallery/views/verify_account.php?requestId=$insert_id&requestPass=$hash'>here</a> to verify account");

                    if ($msg_send_res) {
                        return 0; // message sent successfullly
                    } else {
                        return 5; // unable to send request
                    }
                } else {
                    return 4; // error inserting user request into database
                }
            } else {
                return 3; // limit reached
            }
        } else {
            return 2; // already active
        }
    } else {
        return 1; // no such email exists
    }
}

if (isset($_POST["form-type"]) && $_POST["form-type"] === "verification-form") {
    session_start();
    if (isset($_POST["csrf_token"]) && validateCsrfToken($_POST["csrf_token"])) {
        if (isset($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $result = sendVerificationEmail($_POST["email"]);
            if ($result === 0) {
                echo $result;
            } else {
                echo $result + 2;
            }
        } else {
            echo 2;
        }
    } else {
        echo 1;
    }
}
