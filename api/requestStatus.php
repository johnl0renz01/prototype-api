<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$requestID = $_SERVER['REQUEST_URI'];

for ($i = strlen($requestID) - 1; $i > 0; $i--) {
    if ($requestID[$i] == "/") {
        $requestID = substr($requestID, ($i + 1));
        $requestID = str_replace("_"," ", $requestID);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":      
        $sql = "SELECT Status FROM user_request WHERE RequestID = '$requestID'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchColumn();

        echo json_encode($result);

        break;
    case "POST":
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>