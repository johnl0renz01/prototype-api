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


switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT EquationString FROM equation_list WHERE EquationType = '$equation_type'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
        break;
    case "POST":
        break;
    case "PUT":
        break;
        
    case "DELETE":
        break;
}



?>