<?php
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/vendor/autoload.php");
require_once($root_dir . "/core/general_functions.php");
require_once($root_dir . "/classes/user_db_handle.php");


$email = "person@gmail.com";

echo "<pre>";

function sendVerificationEmail($email)
{
    // connection to database
    $user_handle = new user_db_handle();

    // getting the user verification request info
    $query = "SELECT users.id, username, active, COUNT(user) as num_tries FROM users LEFT JOIN verification_requests ON users.id = verification_requests.user AND timestamp > ? WHERE users.email = ? GROUP BY verification_requests.user";
    $oneDayAgo = time() -  (60 * 60 * 24);
    $result = $user_handle->get($query, "is", $oneDayAgo, $email);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        print_r($user);


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
                        echo 0; // message sent successfullly
                    } else {
                        echo 6; // unable to send request
                    }
                } else {
                    echo 5; // error inserting user request into database
                }
            } else {
                return 4; // limit reached
            }
        } else {
            return 3; // already active
        }
    } else {
        return 2; // no such email exists
    }
}

echo sendVerificationEmail($email);
