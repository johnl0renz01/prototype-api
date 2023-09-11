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
$session_score = "";
$session_angry = "";
$session_happy = "";
$session_sad = "";
$session_surprised = "";
$session_motivation = "";

//FOR MOTIVATION
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_motivation = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

//FOR SURPRISED
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_surprised = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

//FOR SAD
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_sad = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

//FOR HAPPY
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_happy = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

//FOR ANGRY
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_angry = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}


//FOR SCORE
for ($i = strlen($user_key) - 1; $i > 0; $i--) {
    if ($user_key[$i] == "@") {
        $session_score = substr($user_key, ($i + 1));
        $user_key = substr($user_key, 0, $i);
        break;
    }
}

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
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        date_default_timezone_set('Asia/Singapore');
        $sql1 = "SELECT TimeStart FROM $user_key WHERE SessionID = '$session_id'";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        $time_start = $stmt1->fetchColumn();

        $time_start = strtotime($time_start);

        //CONVERT TIME TO SECONDS
        //sscanf($time_start, "%d:%d:%d", $hours, $minutes, $seconds);
        //$time_start_seconds = isset($seconds) ? $hours *   3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
        //GET CURRENT TIME
        
        $current_time = date('d-m-Y H:i:s');
        $current_time = strtotime($current_time);
        //sscanf($current_time, "%d:%d:%d", $hours, $minutes, $seconds);
        //$time_end_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

        //DEDUCT TIME
        $time_spent = $current_time - $time_start;
        //$time_spent = abs($time_start_seconds - $time_end_seconds);
        $time_spent = gmdate("H:i:s", $time_spent);

        $sql2 = "UPDATE $user_key SET Score = '$session_score', TimeSpent = '$time_spent',
                ExpressionAngry = '$session_angry', ExpressionHappy = '$session_happy',
                ExpressionSad = '$session_sad', ExpressionSurprised = '$session_surprised', ExpressionMotivation = '$session_motivation'
                WHERE SessionID = '$session_id'";

        $stmt2 = $conn->prepare($sql2);

        if($stmt2->execute()) {
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