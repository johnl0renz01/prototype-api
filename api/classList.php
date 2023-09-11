<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$section = $_SERVER['REQUEST_URI'];

for ($i = strlen($section) - 1; $i > 0; $i--) {
    if ($section[$i] == "/") {
        $section = substr($section, ($i + 1));
        break;
    }
}

//echo "\n".$section;

switch($_SESSION['method']) {
    case "GET":
        $sql = "SELECT * FROM accounts WHERE Section LIKE '$section' ORDER BY LastName";
        
        $stmt = $conn->prepare($sql);
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            break;
        }
        
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($accounts);
        break;
    case "POST":
        $search = json_decode( file_get_contents('php://input') );
        $inputSearch = $search->searchQuery;
        $inputSearch = trim($inputSearch);

        if (!empty($inputSearch)) {
            $sql = "SELECT * FROM accounts WHERE Section LIKE '$section' AND GivenName LIKE '$inputSearch'
                                        OR Section LIKE '$section' AND GivenName LIKE '%$inputSearch%'
                                        OR Section LIKE '$section' AND GivenName LIKE '%$inputSearch'
                                        OR Section LIKE '$section' AND GivenName LIKE '$inputSearch%'
                                        
                                        OR Section LIKE '$section' AND LastName LIKE '$inputSearch'
                                        OR Section LIKE '$section' AND LastName LIKE '%$inputSearch%'
                                        OR Section LIKE '$section' AND LastName LIKE '%$inputSearch'
                                        OR Section LIKE '$section' AND LastName LIKE '$inputSearch%'

                                        OR Section LIKE '$section' AND Age LIKE '$inputSearch'
                                        OR Section LIKE '$section' AND Age LIKE '%$inputSearch%'
                                        OR Section LIKE '$section' AND Age LIKE '%$inputSearch'
                                        OR Section LIKE '$section' AND Age LIKE '$inputSearch%'

                                        OR Section LIKE '$section' AND Gender LIKE '$inputSearch'
                                        OR Section LIKE '$section' AND Gender LIKE '$inputSearch%'

                                        OR Section LIKE '$section' AND GroupType LIKE '$inputSearch'
                                        OR Section LIKE '$section' AND GroupType LIKE '%$inputSearch%'
                                        OR Section LIKE '$section' AND GroupType LIKE '%$inputSearch'
                                        OR Section LIKE '$section' AND GroupType LIKE '$inputSearch%'
                                        OR Section LIKE '$section' AND CONCAT(GivenName, ' ', Lastname) LIKE '$inputSearch'
                                        ORDER BY LastName";

        } else {
            $sql = "SELECT * FROM accounts WHERE Section LIKE '$section' ORDER BY LastName";
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