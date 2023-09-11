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

$difficulty_type = "";

for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $difficulty_type = ucfirst(substr($user_key, ($i + 1))); //capital first letter
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO $user_key (SessionID, SessionType, Score, TimeSpent, TimeStamp, TimeStart) VALUES(null, '$difficulty_type', '0', '0', :timestamp, :start_time)";
        $stmt = $conn->prepare($sql);
        date_default_timezone_set('Asia/Singapore');
        $timestamp = date('M d, Y - h:i A');
        $stmt->bindParam(':timestamp', $timestamp);
        $start_time = date('d-m-Y H:i:s');
        $stmt->bindParam(':start_time', $start_time);
        
        if($stmt->execute()) {
            $sql2 = "SELECT SessionID FROM $user_key ORDER BY SessionID DESC LIMIT 1";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $response = $stmt2->fetchColumn();
            
            echo json_encode($response);
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>