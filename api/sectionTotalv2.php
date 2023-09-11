<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();


$adviser = $_SERVER['REQUEST_URI'];

for ($i = strlen($adviser) - 1; $i > 0; $i--) {
    if ($adviser[$i] == "/") {
        $adviser = substr($adviser, ($i + 1));
        $adviser = str_replace("_"," ", $adviser);
        break;
    }
}


switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT count(SectionID) FROM section_list WHERE AdviserName = '$adviser'";
        //$path = explode('/', $_SERVER['REQUEST_URI']);
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $number_of_rows = $stmt->fetchColumn();

        echo json_encode($number_of_rows);
        break;
    case "POST":
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>