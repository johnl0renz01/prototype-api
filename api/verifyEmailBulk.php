<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$email = $_SERVER['REQUEST_URI'];

for ($i = strlen($email) - 1; $i > 0; $i--) {
    if ($email[$i] == "/") {
        $email = substr($email, ($i + 1));
        break;
    }
}

$row_id = "";

//FOR ROW ID
for ($i = strlen($email) - 1; $i > 0; $i--) {
    if ($email[$i] == "@") {
        $row_id = substr($email, ($i + 1));
        $email = substr($email, 0, $i);
        $email = str_replace("_"," ", $email);
        break;
    }
}


switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT * FROM accounts WHERE Email = '$email'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            echo json_encode($row_id);
        } else {
            echo json_encode("unique");
        }
        break;
    case "POST":
        
        break;
    case "PUT":
        break;
        
    case "DELETE":
        break;
}



?>