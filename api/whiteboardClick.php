<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$user_email = $_SERVER['REQUEST_URI'];


for ($i = strlen($user_email) - 1; $i > 0; $i--) {
    if ($user_email[$i] == "/") {
        $user_email = substr($user_email, ($i + 1));
        break;
    }
}

$input_click = "";

//FOR DATA INPUT CLICK
for ($i = strlen($user_email) - 1; $i > 0; $i--) {
    if ($user_email[$i] == "@") {
        $input_click = substr($user_email, ($i + 1));
        $input_click = str_replace("_"," ", $input_click);
        $user_email = substr($user_email, 0, $i);
        break;
    }
}


$session_id = "";
$session_user = "";
$temp_key = "";
$isChanged = false;
for ($i = strlen($user_email) - 1; $i > 0; $i--) {
    if ($user_email[$i] == "@") {
        if ($isChanged) {
            $session_id = substr($temp_key, ($i + 1));
            $user_email = substr($user_email, 0, $i);
            break;
        } else {
            $isChanged = true;
            $session_user = substr($user_email, ($i + 1));
            $session_user = str_replace("_"," ", $session_user);
            $temp_key = substr($user_email, 0, $i);
        }
    }
}


/*
echo "\n\n\n SESSION EMAIL";
echo $user_email;
echo "\nSESSION ID";
echo $session_id;
echo "\n";

echo "\nSESSION USER";
echo $session_user;
*/

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO user_logs(inputID, user, input, timestamp, user_email, session_id) VALUES(null, '$session_user', '$input_click', :timestamp, '$user_email', '$session_id')";
        $stmt = $conn->prepare($sql);
        date_default_timezone_set('Asia/Singapore');
        $timestamp = date('Y-m-d h:i:sa');
        $stmt->bindParam(':timestamp', $timestamp);

        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        //echo "\n";
        echo json_encode($response);
        break;

    case "PUT":
        break;
        
    case "DELETE":
        break;
}



?>