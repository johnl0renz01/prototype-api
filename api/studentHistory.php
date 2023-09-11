<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$account_database = $_SERVER['REQUEST_URI'];

for ($i = strlen($account_database) - 1; $i > 0; $i--) {
    if ($account_database[$i] == "/") {
        $account_database = substr($account_database, ($i + 1));
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT * FROM $account_database ORDER BY SessionID DESC";
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