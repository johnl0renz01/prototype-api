<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$equation_type = $_SERVER['REQUEST_URI'];


for ($i = strlen($equation_type) - 1; $i > 0; $i--) {
    if ($equation_type[$i] == "/") {
        $equation_type = substr($equation_type, ($i + 1));
        break;
    }
}

$equation_string = ""; 

for ($i = strlen($equation_type) - 1; $i > 0; $i--) {
    if ($equation_type[$i] == "@") {
        $equation_string = substr($equation_type, ($i + 1));
        $equation_string = str_replace("_"," ", $equation_string);
        $equation_type = substr($equation_type, 0, $i);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO equation_list(equationID, EquationType, EquationString) VALUES(null, '$equation_type', '$equation_string')";
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