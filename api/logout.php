<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$unique = $_SERVER['REQUEST_URI'];

for ($i = strlen($unique) - 1; $i > 0; $i--) {
    if ($unique[$i] == "/") {
        $unique = substr($unique, ($i + 1));
        break;
    }
}

echo $unique;



switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        
        $sql = "UPDATE sessions SET Logged = 'FALSE'
                WHERE UniqueID = '$unique'";

        $stmt = $conn->prepare($sql);
        
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo json_encode($unique);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>