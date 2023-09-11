<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Origin: *");

ob_start();
session_start();

/*
echo $test = '{
    "name": "asd",
    "age": 12
}';
*/


/*
$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case "POST":
        $user = $_POST['rawList'];
        $_SESSION['questionString'] = $user;
        echo ("Hello from server: $user");

        $response = $_SESSION['questionString'];
        echo json_encode($response);
        break;
    }
*/

$user = "$_POST['rawList']";


$_SESSION['currentSession'] = false;
$_SESSION['questionString'] = $user;
echo "".$_SESSION['questionString']."";


$_SESSION['currentQuestions'] = array();

?>