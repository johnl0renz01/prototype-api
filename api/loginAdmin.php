<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $admin = $user->username;
        $password = $user->password;
        
        if ($admin == "Admin" && $password == "password") {
            echo json_encode("Admin");
        } else {
            echo json_encode("Invalid");
        }
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>