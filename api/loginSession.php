<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

function random_str(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

$a = random_str(32);
$b = random_str(8, 'abcdefghijklmnopqrstuvwxyz');
$c = random_str();

switch($_SESSION['method']) {
    case "GET":
        break;
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $unique = $c;
        
        $email = $user->email;

        //LOGOUT OTHER SESSIONS
        $logged = "FALSE";
        $sql0 = "UPDATE sessions SET Logged = 'FALSE'
        WHERE UserEmail = '$email'";

        $stmt0 = $conn->prepare($sql0);
        $stmt0->execute();
        //////

        $logged = "TRUE";
        
        $sql = "INSERT INTO sessions(SessionID, UniqueID, UserEmail, Logged) 
                VALUES(null, '$unique', :email, '$logged')";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $user->email);
        
        if($stmt->execute()) {
            $sql2 = "SELECT UniqueID FROM sessions ORDER BY SessionID DESC LIMIT 1";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute();
            $result = $stmt2->fetchColumn();
            echo json_encode($result);
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>