<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$account_email = $_SERVER['REQUEST_URI'];

for ($i = strlen($account_email) - 1; $i > 0; $i--) {
    if ($account_email[$i] == "/") {
        $account_email = substr($account_email, ($i + 1));
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        
        //date_default_timezone_set('Asia/Singapore');
        //$session_started = date('M d, Y - h:iA');
        //echo "\n".$session_started."\n";

        $sql = "SELECT * FROM accounts WHERE Email LIKE '$account_email'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $account = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($account);
        break;
    case "POST":
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}

?>