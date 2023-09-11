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

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $default = "default";
        $sql = "UPDATE accounts SET Password = '$default'
                WHERE Email = '$email'";

        $stmt = $conn->prepare($sql);
        
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        $sql2 = "DELETE FROM reset_request WHERE Email = '$email'";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();

        echo json_encode($response);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>