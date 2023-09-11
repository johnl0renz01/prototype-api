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

$password = "";
for ($i = strlen($email) - 1; $i > 0; $i--) {
    if ($email[$i] == "@") {
        $password = substr($email, ($i + 1));
        $password = str_replace("_"," ", $password);
        $email = substr($email, 0, $i);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE accounts SET Password = '$hashedPassword'
                WHERE Email = '$email'";

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