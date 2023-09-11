<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$type = $_SERVER['REQUEST_URI'];

//echo $type;


for ($i = strlen($type) - 1; $i > 0; $i--) {
    if ($type[$i] == "/") {
        $type = substr($type, ($i + 1));
        break;
    }
}


$equation = "";

for ($i = strlen($type) - 1; $i > 0; $i--) {
    if ($type[$i] == "@") {
        $equation = substr($type, ($i + 1));
        $equation = str_replace("_"," ", $equation);
        $type = substr($type, 0, $i);
        break;
    }
}



switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        
        $sql = "UPDATE equation_list SET EquationType = '$type'
                WHERE EquationString = '$equation'";

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