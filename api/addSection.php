<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();


switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
    
        
        $sql = "INSERT INTO section_list(SectionID, GradeLevel, SectionName, AdviserName) 
        VALUES(null, :gradeLevel, :sectionName, :adviserName)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':gradeLevel', $user->gradeLevel);
        $stmt->bindParam(':sectionName', $user->sectionName);
        $stmt->bindParam(':adviserName', $user->adviserName);
        
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo "\n".json_encode($response);
        break;
    case "PUT":
        break;
        
    case "DELETE":
        break;
}



?>