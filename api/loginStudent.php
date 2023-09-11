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
        $sql = "SELECT GivenName, Email, Password, GroupType, MiddleName, LastName FROM accounts WHERE Email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $user->email);
        //$stmt->bindParam(':password', $user->password);
        $passwordInput = $user->password;
        //echo "\n".$passwordInput;

        $stmt->execute();
        $account = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        if (count($account) > 0) {
            $password = implode(",", $account[0]);
            $password = explode(",", $password);
            if(password_verify($passwordInput, $password[2]) || $passwordInput == $password[2]) { //Hashed Password and Not hashed
                if ($passwordInput == "default") {
                    echo json_encode("setPassword");
                } else {
                    echo json_encode($account);
                }
                
            } else {
                echo json_encode("Invalid");
            }
        } else {
            echo json_encode("Invalid");
        }

        
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>