<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$section_index = $_SERVER['REQUEST_URI'];

for ($i = strlen($section_index) - 1; $i > 0; $i--) {
    if ($section_index[$i] == "/") {
        $section_index = substr($section_index, ($i + 1));
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT SectionName FROM section_list ORDER BY GradeLevel ASC, SectionName ASC LIMIT $section_index, 1 ";
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