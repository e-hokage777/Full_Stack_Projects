<?php
session_start();

// including necessary files
$root_dir = $_SERVER["DOCUMENT_ROOT"] . "/projects/My Gallery";
require_once($root_dir . "/core/general_functions.php");

if(isset($_POST["csrf_token"]) && validateCsrfToken($_POST["csrf_token"])){
$_SESSION = array();
session_destroy();

echo 0;
}
else{
    echo 1;
}
