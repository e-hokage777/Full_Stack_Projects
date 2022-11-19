<?php 
session_start();

$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/core/general_functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/form_page.css">
    <title>My Gallery - Login</title>
</head>

<body>
    <div class="wrapper">
        <div class="main-container">
            <header>
                <div class="logo">
                    <img src="../assets/images/icons/Logo.png" alt="logo">
                </div>
                <div class="buttons">
                    <a class="btn" href="signup.php">Sign Up</a>
                </div>
            </header>
            <form id="login-form">
                <h1>Login</h1>
                <div id="login-success" class="success-field">
                    Login Successful
                </div>
                <div id="general-error" class="error-field">An unexpected error occured</div>
                <div class="inputs">
                    <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>" />
                    <div>
                        <input type="text" name="email" placeholder="Email">
                        <div id="email-error-field" class="error-field">Please enter valid email</div>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password"/>
                        <div id="password-error-field" class="error-field">Please enter valid password</div>
                    </div>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
        <div class="wave1"></div>
        <div class="wave2"></div>
    </div>
    <script src="../assets/js/general.js"></script>
    <script src="../assets/js/authenticate.js"></script>
</body>

</html>