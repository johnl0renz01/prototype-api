<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$requestID= $_SERVER['REQUEST_URI'];

for ($i = strlen($requestID) - 1; $i > 0; $i--) {
    if ($requestID[$i] == "/") {
        $requestID = substr($requestID, ($i + 1));
        break;
    }
}


switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $status = "SOLVED";
        
        $sql = "UPDATE user_request SET Status = '$status'
                WHERE RequestID = '$requestID'";
         $stmt = $conn->prepare($sql);
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo json_encode($response);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>