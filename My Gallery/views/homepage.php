<?php
session_start();

// importing some necessary libraries
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/classes/user_db_handle.php");


if (!isset($_SESSION["userId"]) || !isset($_SESSION["isUserLoggedIn"]) || !($_SESSION["isUserLoggedIn"] === true)) {
    header("location:login.php");
} else {
    // get user details
    $user_db_handle = new user_db_handle();
    $res = $user_db_handle->get("SELECT username FROM users WHERE id = ?", "i", $_SESSION["userId"]);

    if (!$res || !($res->num_rows === 1)) {
        echo "Error fetching user from database";
    } else {
        $user = $res->fetch_assoc();
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="../assets/css/general.css">
            <link rel="stylesheet" href="../assets/css/homepage.css">
            <title>Home Page</title>
        </head>

        <body>
            <div class="wrapper">
                <div class="main-container">
                    <header class="nav-header">
                        <div class="logo">
                            <img src="../assets/images/icons/Logo.png" alt="logo">
                        </div>
                        <div class="title">
                            <h1><?php echo $user["username"] . "'s" ?> gallery</h1>
                        </div>
                        <div class="buttons">
                            <button class="header-button">
                                <i class="fa-solid fa-circle-user"></i>
                            </button>
                            <button class="header-button">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </div>
                    </header>
                    <div class="gallery-container">
                        <div class="gallery-container-inner">
                            <div class="row">
                                <div class="gallery-card col-lg-6 p-5">
                                    <div class="gallery-card-inner">
                                        <div class="gallery-img-container">
                                            <img src="../img.jpg" alt="">
                                        </div>
                                        <div class="art-desc">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, a.</div>
                                    </div>
                                </div>
                                <div class="gallery-card col-lg-6 p-5">
                                    <div class="gallery-card-inner">
                                        <div class="gallery-img-container">
                                            <img src="../img.jpg" alt="">
                                        </div>
                                        <div class="art-desc">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, a.</div>
                                    </div>
                                </div>
                                <div class="gallery-card col-lg-6 p-5">
                                    <div class="gallery-card-inner">
                                        <div class="gallery-img-container">
                                            <img src="../img.jpg" alt="">
                                        </div>
                                        <div class="art-desc">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, a.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wave1"></div>
                <div class="wave2"></div>
            </div>
            <script src="assets/js/general.js"></script>

        </body>

        </html>
<?php
    }
}
?>