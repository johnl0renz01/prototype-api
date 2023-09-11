<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$equation = $_SERVER['REQUEST_URI'];

for ($i = strlen($equation) - 1; $i > 0; $i--) {
    if ($equation[$i] == "/") {
        $equation = substr($equation, ($i + 1));
        $equation = str_replace("_"," ", $equation);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $sql = "DELETE FROM equation_list WHERE EquationString = '$equation'";
        //$path = explode('/', $_SERVER['REQUEST_URI']);
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>