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
        $sql = "SELECT * FROM accounts WHERE Role = 'Teacher' ORDER BY LastName";
        //$path = explode('/', $_SERVER['REQUEST_URI']);
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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