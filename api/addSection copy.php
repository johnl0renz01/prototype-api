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

echo "HELLO THERE: ".$equation_type;
switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );

        $profile = $user->profile;
        echo "\nprofile: ".$profile;
        $images=$_FILES[$profile]['name'];
		$tmp_dir=$_FILES[$profile]['tmp_name'];
		$imageSize=$_FILES[$profile]['size'];

		$upload_dir='uploads/';
		$imgExt=strtolower(pathinfo($images,PATHINFO_EXTENSION));
		$valid_extensions=array('jpeg', 'jpg', 'png', 'gif', 'pdf');
		$picProfile=rand(1000, 1000000).".".$imgExt;
		move_uploaded_file($tmp_dir, $upload_dir.$picProfile);
		$stmt=$db_conn->prepare('INSERT INTO section_list(SectionID, SectionImage) VALUES (null, :upic)');
		$stmt->bindParam(':upic', $picProfile);

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