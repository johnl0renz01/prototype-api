<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$user_key = $_SERVER['REQUEST_URI'];

for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "/") {
        $user_key = substr($user_key, ($i + 1));
        break;
    }
}

$session_id = "";


//FOR SESSION ID
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_id = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT TimeSpent FROM $user_key WHERE SessionID = '$session_id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $response = $stmt->fetchColumn();

        echo json_encode($response);
        break;
    case "POST":
       
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>