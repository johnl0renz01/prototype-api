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
        $email = str_replace("_"," ", $email);
        break;
    }
}

switch($_SESSION['method']) {
    case "GET":
        $midname = "SELECT MiddleName FROM accounts WHERE Email = '$email'";
        $mn = $conn->prepare($midname);
        $mn->execute();

        $output = $mn->fetchColumn();
        $name = "";

        if ($output != "") {
            $fullname = "SELECT concat(GivenName, ' ', MiddleName, ' ', LastName) AS FullName FROM accounts WHERE Email = '$email'";
            $fn = $conn->prepare($fullname);
            $fn->execute();
            $name = $fn->fetchColumn();
        } else {
            $fullname = "SELECT concat(GivenName, ' ', LastName) AS FullName FROM accounts WHERE Email = '$email'";
            $fn = $conn->prepare($fullname);
            $fn->execute();
            $name = $fn->fetchColumn();
        }

      
        $sql = "SELECT * FROM section_list WHERE AdviserName = '$name'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        if (count($result) > 0) {
            echo json_encode("Assigned");
        } else {
            echo json_encode("Unassigned");
        }

        break;
    case "POST":
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>