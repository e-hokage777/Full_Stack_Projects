<?php
session_start();

// importing necessary files
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/core/general_functions.php");
require_once($root_dir . "/classes/user_db_handle.php");

$verified = false;
$error_msg = "";

if (isset($_GET["requestId"]) && isset($_GET["requestPass"])) {
    // getting request data from database
    $user_db_handle = new user_db_handle();

    $query = "SELECT * FROM verification_requests WHERE id = ?";
    $result = $user_db_handle->get($query, "i", $_GET["requestId"]);

    if ($result && $result->num_rows === 1) {
        $request = $result->fetch_assoc();
        if (time() - $request["timestamp"] < (60 * 60 * 24)) {

            // verifying request hash
            $hashInDB  = $request["hash"];

            if (hash_equals($hashInDB, $_GET["requestPass"])) {

                // verifying the user
                if ($user_db_handle->activateUserAccount($request["id"])) {
                    $verified = true;
                } else {
                    $error_msg = "An unexpected error occured: Account counld note be verified";
                }
            } else {
                $error_msg = "Invalid Verification request";
            }
        } else {
            $error_msg = "Verification request has expired";
        }
    } else {
        $error_msg = "You haven't made any validation request, with the specified id";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/form_page.css">
    <title>My Gallery - Send Verification Email</title>
</head>

<body>
    <?php if (!$verified) { ?>
        <div class="wrapper">
            <div class="main-container">
                <header>
                    <div class="logo">
                        <img src="../assets/images/icons/Logo.png" alt="logo">
                    </div>
                    <div class="buttons">
                        <a class="btn" href="signup.php">Sign Up</a>
                        <a class="btn" href="login.php">Login</a>
                    </div>
                </header>
                <?php
                if ($error_msg) {
                    echo "<h1 text-align: center;>$error_msg</h1>";
                }
                ?>
                <form action="" id="verification-form" method="post">
                    <h1>Send Verification Email</h1>
                    <div id="register-success" class="success-field">
                        Check your inbox to verify your account
                    </div>
                    <div id="general-error" class="error-field">An unexpected error occured</div>
                    <div class="inputs">
                        <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>">
                        <div>
                            <input type="text" name="email" placeholder="Email">
                        </div>
                    </div>
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
            <div class="wave1"></div>
            <div class="wave2"></div>
        </div>
    <?php
    } else {
        echo "<h1>Account already Active</h1>";
    }
    ?>
    <script src="../assets/js/general.js"></script>
    <script src="../assets/js/authenticate.js"></script>
</body>

</html>