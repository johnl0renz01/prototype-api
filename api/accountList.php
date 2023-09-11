<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

//echo "\n".$section;

switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT * FROM accounts ORDER BY LastName";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($accounts);
        break;
    case "POST":
        $search = json_decode( file_get_contents('php://input') );
        $inputSearch = $search->searchQuery;
        $inputSearch = trim($inputSearch);

        if (!empty($inputSearch)) {
            $sql = "SELECT * FROM accounts WHERE GivenName LIKE '$inputSearch'
                                        OR GivenName LIKE '%$inputSearch%'
                                        OR GivenName LIKE '%$inputSearch'
                                        OR GivenName LIKE '$inputSearch%'
                                        
                                        OR LastName LIKE '$inputSearch'
                                        OR LastName LIKE '%$inputSearch%'
                                        OR LastName LIKE '%$inputSearch'
                                        OR LastName LIKE '$inputSearch%'

                                        OR MiddleName LIKE '$inputSearch'
                                        OR MiddleName LIKE '%$inputSearch%'
                                        OR MiddleName LIKE '%$inputSearch'
                                        OR MiddleName LIKE '$inputSearch%'

                                        OR Role LIKE '$inputSearch'
                                        OR Role LIKE '%$inputSearch%'
                                        OR Role LIKE '%$inputSearch'
                                        OR Role LIKE '$inputSearch%'

                                        OR Email LIKE '$inputSearch'
                                        OR Email LIKE '%$inputSearch%'
                                        OR Email LIKE '%$inputSearch'
                                        OR Email LIKE '$inputSearch%'

                                        OR Section LIKE '$inputSearch'
                                        OR Section LIKE '%$inputSearch%'
                                        OR Section LIKE '%$inputSearch'
                                        OR Section LIKE '$inputSearch%'

                                        OR CONCAT(GivenName, ' ', LastName) LIKE '$inputSearch'
                                        OR CONCAT(GivenName, ' ', LastName) LIKE '%$inputSearch%'
                                        OR CONCAT(GivenName, ' ', LastName) LIKE '%$inputSearch'
                                        OR CONCAT(GivenName, ' ', LastName) LIKE '$inputSearch%'


                                        OR CONCAT(GivenName, ' ', MiddleName) LIKE '$inputSearch'
                                        OR CONCAT(GivenName, ' ', MiddleName) LIKE '%$inputSearch%'
                                        OR CONCAT(GivenName, ' ', MiddleName) LIKE '%$inputSearch'
                                        OR CONCAT(GivenName, ' ', MiddleName) LIKE '$inputSearch%'

                                        OR CONCAT(MiddleName, ' ', LastName) LIKE '$inputSearch'
                                        OR CONCAT(MiddleName, ' ', LastName) LIKE '%$inputSearch%'
                                        OR CONCAT(MiddleName, ' ', LastName) LIKE '%$inputSearch'
                                        OR CONCAT(MiddleName, ' ', LastName) LIKE '$inputSearch%'

                                        OR CONCAT(GivenName, ' ', MiddleName, ' ', LastName) LIKE '$inputSearch'
                                        OR CONCAT(GivenName, ' ', MiddleName, ' ', LastName) LIKE '%$inputSearch%'
                                        OR CONCAT(GivenName, ' ', MiddleName, ' ', LastName) LIKE '%$inputSearch'
                                        OR CONCAT(GivenName, ' ', MiddleName, ' ', LastName) LIKE '$inputSearch%'
                                        
                                        ORDER BY LastName";

        } else {
            $sql = "SELECT * FROM accounts ORDER BY LastName";
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($accounts);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>