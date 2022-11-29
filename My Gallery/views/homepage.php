<?php
session_start();

// importing some necessary libraries
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/classes/user_db_handle.php");
require_once($root_dir . "/core/general_functions.php");



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

        $user_art = $user_db_handle->get("SELECT * FROM uploads WHERE user = ?", "i", $_SESSION["userId"]);

        if (!$user_art) {
            echo "Error fetching user art";
        }
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
                            <h1><?php echo htmlspecialchars($user["username"]) . "'s" ?> gallery</h1>
                        </div>
                        <div class="buttons">
                            <button id="user-button" class="header-button">
                                <i class="fa-solid fa-circle-user"></i>
                            </button>
                            <button id="gallery-menu-button" class="header-button">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </div>
                    </header>
                    <div class="gallery-container">
                        <div class="gallery-container-inner">
                            <div class="row">
                                <!-- <div class="gallery-card col-lg-6 p-5">
                                    <div class="gallery-card-inner">
                                        <div class="gallery-img-container">
                                            <img src="../img.jpg" alt="">
                                        </div>
                                        <h4 class="art-title">Title</h4>
                                        <div class="art-desc">
                                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, a.</p>
                                        </div>
                                    </div>
                                </div> -->
                                <?php
                                if ($user_art->num_rows > 0) {

                                    while ($art = $user_art->fetch_assoc()) {
                                        $art_id = $art["id"];
                                        $art_title = $art["title"];
                                        $art_description = $art["description"];
                                        $art_name = htmlspecialchars($art["name"]);
                                        $art_location = $art["location"];

                                        $username = htmlspecialchars($user["username"]);


                                        // checking if title and description were given
                                        $art_title = htmlspecialchars($art_title ? $art_title : $user["username"] . "'s Art");
                                        $art_description = htmlspecialchars($art_description ? $art_description : "Art created by " . $user["username"]);

                                        // csrf token
                                        $token = createCsrfToken();

                                        echo "  <div class='gallery-card col-lg-6 p-5'>
                                                    <div class='gallery-card-inner'>
                                                        <div class='gallery-img-container'>
                                                            <img src='../uploads/$username/$art_name' alt='$art_title'>
                                                        </div>
                                                        <h4 class='art-title'>$art_title</h4>
                                                        <div class='art-desc'>$art_description</div>
                                                        <form class='gallery-item-delete-form' method='post'>
                                                            <input type='hidden' name='csrf_token' value='$token'>
                                                            <input type='hidden' name='item-id' value='$art_id'>
                                                            <button type='submit' class='gallery-item-delete'><i class='fa-solid fa-trash'></i></button>
                                                    </form>
                                                    </div>
                                                </div>";
                                    }
                                } else {
                                    echo "<h1 style='position: absolute; top: 50%; left: 0; width: 100%; text-align: center; color: white;'>You have no art in your gallery</h1>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="user-menu">
                        <button class="close-user-menu">X</button>
                        <ul class="user-menu-links">
                            <li>
                                <form id="logout-form" method="post">
                                    <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>">
                                    <input class="menu-button" type="submit" value="Logout">
                                </form>
                            </li>
                            <li>
                                <form id="delete-account-form" method="post">
                                    <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>">
                                    <input class="menu-button" type="submit" value="Delete Account">
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="gallery-menu">
                        <button class="close-gallery-menu">X</button>
                        <ul class="gallery-menu-links">
                            <li>
                                <button class="menu-button add-to-gallery">Add to Gallery</button>
                            </li>
                        </ul>
                    </div>
                    <!-- form for uploading -->
                    <div class="full-screen-container">
                        <form id="upload-form">
                            <h1>Add to Gallery</h1>
                            <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>">
                            <div id="upload-success" class="success-field">
                                New item added to gallery successfully
                            </div>
                            <div id="general-error" class="error-field">An unexpected error occured</div>
                            <input type="hidden" name="csrf_token" value="<?php echo createCsrfToken() ?>" />
                            <div>
                                <input type="text" name="title" placeholder="Title">
                                <div id="email-error-field" class="error-field">Please enter a title</div>
                            </div>
                            <div>
                                <textarea name="info" id="gallery-item-info" cols="30" rows="10" placeholder="Say something about your art"></textarea>
                            </div>
                            <div>
                                <input type="file" name="gallery-file" id="gallery-file-input" accept=".png, .jpeg, .jpg">
                            </div>
                            <button type="submit" class="btn">Submit</button>
                        </form>
                    </div>
                </div>
                <div id="art-display">
                    <div class="title">some title</div>
                    <div class="art-display-inner">
                        <img src="../uploads/test/699287.jpg">
                    </div>
                    <div class="desc">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vitae, labore.</div>
                </div>
                <div class="wave1"></div>
                <div class="wave2"></div>
            </div>
            <script src="../assets/js/general.js"></script>
            <script src="../assets/js/authenticate.js"></script>
            <script src="../assets/js/homepage.js"></script>
        </body>

        </html>
<?php
    }
}
?>