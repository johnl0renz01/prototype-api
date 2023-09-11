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
        $sql = "SELECT SectionName FROM section_list WHERE AdviserName = '$adviser' ORDER BY GradeLevel ASC, SectionName ASC LIMIT 0, 1 ";
        //$path = explode('/', $_SERVER['REQUEST_URI']);
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchColumn();

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