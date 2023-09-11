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
        $sql = "SELECT * FROM user_request ORDER BY UserID DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($requests);
        break;
    case "POST":
        $search = json_decode( file_get_contents('php://input') );
        $inputSearch = $search->searchQuery;
        $inputSearch = trim($inputSearch);

        if (!empty($inputSearch)) {
            $sql = "SELECT * FROM user_request WHERE Subject LIKE '$inputSearch'
                                        OR Subject LIKE '%$inputSearch%'
                                        OR Subject LIKE '%$inputSearch'
                                        OR Subject LIKE '$inputSearch%'
                                        
                                        OR Email LIKE '$inputSearch'
                                        OR Email LIKE '%$inputSearch%'
                                        OR Email LIKE '%$inputSearch'
                                        OR Email LIKE '$inputSearch%'

                                        OR Role LIKE '$inputSearch'
                                        OR Role LIKE '%$inputSearch%'
                                        OR Role LIKE '%$inputSearch'
                                        OR Role LIKE '$inputSearch%'

                                        OR Status LIKE '$inputSearch'
                                        OR Status LIKE '$inputSearch%'

                                        OR Timestamp LIKE '$inputSearch'
                                        OR Timestamp LIKE '%$inputSearch%'
                                        OR Timestamp LIKE '%$inputSearch'
                                        OR Timestamp LIKE '$inputSearch%'
                                        
                                        ORDER BY UserID DESC";

        } else {
            $sql = "SELECT * FROM user_request ORDER BY UserID DESC";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($requests);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>