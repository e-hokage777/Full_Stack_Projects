<?php

//ROOT PATH
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery/");

// DATABASE CONSTANTS
define("DB_HOSTNAME", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", null);
define("DB_NAME", "my_gallery");
// define("DB_ACCESS_PORT", 3306);


// SECURITY CONSTANTS
define("CSRF_TOKEN_KEY", "ldfjldkjfd");
define("SEPARATOR", "|-~-|");
define("MAX_VERIFICATION_ATTEMPTS", 5);

//EMAIL SERVER CONSTANTS
define("SMTP_HOST", "smtp.gmail.com");
define("SMTP_USERNAME", "e.hokage777@gmail.com");
define("SMTP_PASSWORD", "<somerandompassword>");
define("SMTP_FROM", "e.hokage777@gmail.com");
define("SMTP_FROM_NAME", "The Host");


// FILE CONSTANTS
define("MAX_FILE_SIZE", 10000000);
define("UPLOAD_DIR", ROOT_PATH . "uploads/");