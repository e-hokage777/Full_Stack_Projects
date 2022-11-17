<?php
session_start();

require_once("../core/general_functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/form_page.css">
    <title>My Gallery - Register</title>
    <!-- <style>
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        form {
            border: solid white 1px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 2rem;
            width: 400px;
            height: 500px;
            backdrop-filter: blur(5px);
            border-top-left-radius: 100px;
            border-bottom-right-radius: 100px;
        }

        form h1 {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: white;
        }

        form .inputs {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: space-evenly;
        }

        form .inputs input {
            border: none;
            border-bottom: solid #3B9DCF 1px;
            background-color: transparent;
            outline: none;
            text-align: center;
            font-size: 1.1rem;
            width: 100%;
        }

        form button {
            margin: auto;
            color: #69EB7F !important;
            border-color: #69EB7F !important;
        }
    </style> -->
</head>

<body>
    <div class="wrapper">
        <div class="main-container">
            <header>
                <div class="logo">
                    <img src="../assets/images/icons/Logo.png" alt="logo">
                </div>
                <div class="buttons">
                    <a class="btn" href="login.php">Login</a>
                </div>
            </header>
            <form action="" id="signup-form">
                <h1>Register</h1>
                <div id="register-success" class="success-field">
                    Account has been created successfully<br>
                    Please check your inbox to verify your account
                </div>
                <div id="general-error" class="error-field">An unexpected error occured</div>
                <div class="inputs">
                    <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>">
                    <div>
                        <input type="text" name="username" placeholder="Username">
                        <div id="username-error-field" class="error-field">Please enter valid username</div>
                    </div>
                    <div>
                        <input type="text" name="email" placeholder="Email">
                        <div id="email-error-field" class="error-field">Please enter valid email</div>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password">
                        <div id="password-error-field" class="error-field">Please enter valid password</div>
                    </div>
                    <div>
                        <input type="password" name="confirm-password" placeholder="Confirm-password">
                        <div id="confirm-password-error-field" class="error-field">Please enter valid username</div>
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