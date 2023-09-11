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
        $default = "default";

        $validate = "SELECT * FROM code_list WHERE Code = :code";
        $req->bindParam(':code', $user->code);
        $req = $conn->prepare($validate);
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            $sql = "UPDATE accounts SET Password = '$default'
                    WHERE Email = :email";
            $stmt->bindParam(':email', $user->emailReset);
            $stmt = $conn->prepare($sql);
            
            if($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record created successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to create record.'];
            }
            echo json_encode($response);
        }
        
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>