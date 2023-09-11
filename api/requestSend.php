<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$email = $_SERVER['REQUEST_URI'];

for ($i = strlen($email) - 1; $i > 0; $i--) {
    if ($email[$i] == "/") {
        $email = substr($email, ($i + 1));
        break;
    }
}

$role = "";

for ($i = strlen($email) - 1; $i > 0; $i--) {
    if ($email[$i] == "@") {
        $role = substr($email, ($i + 1));
        $email = substr($email, 0, $i);
        break;
    }
}

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
        $status = "UNSOLVED";
        $id = $c;

        $sql = "INSERT INTO user_request(UserID, Subject, Message, Email, Role, Status, RequestID, Timestamp) 
                VALUES(null, :subject, :message, '$email', '$role', '$status', '$id', :timestamp)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':subject', $user->subject);
        $stmt->bindParam(':message', $user->message);

        date_default_timezone_set('Asia/Singapore');
        $timestamp = date('M d, Y - h:i A');
        $stmt->bindParam(':timestamp', $timestamp);
        
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }

        echo json_encode($response);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>