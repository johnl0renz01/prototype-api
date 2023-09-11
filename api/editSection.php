<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$section = $_SERVER['REQUEST_URI'];

for ($i = strlen($section) - 1; $i > 0; $i--) {
    if ($section[$i] == "/") {
        $section = substr($section, ($i + 1));
        $section = str_replace("_"," ", $section);
        break;
    }
}


switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $adviserName = $user->adviserName;
        $gradeLevel = $user->gradeLevel;
        $sectionName = $user->sectionName;
        
        $sql = "UPDATE section_list SET GradeLevel = '$gradeLevel', SectionName = '$sectionName', AdviserName = '$adviserName'
                WHERE SectionName = '$section'";

        $stmt = $conn->prepare($sql);
        
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        $sql2 = "UPDATE accounts SET Section = '$sectionName' WHERE Section = '$section'";

        $stmt2 = $conn->prepare($sql2);
        
        if($stmt2->execute()) {
            $response2 = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response2 = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo "\n".json_encode($response);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>