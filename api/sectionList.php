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
        $sql = "SELECT * FROM section_list ORDER BY SectionName";
        //$path = explode('/', $_SERVER['REQUEST_URI']);
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($result);
        break;
    case "POST":
        $search = json_decode( file_get_contents('php://input') );
        $inputSearch = $search->searchQuery;
        $inputSearch = trim($inputSearch);

        if (!empty($inputSearch)) {
            $sql = "SELECT * FROM section_list 
                                        WHERE GradeLevel LIKE '$inputSearch'
                                        OR GradeLevel LIKE '%$inputSearch%'
                                        OR GradeLevel LIKE '%$inputSearch'
                                        OR GradeLevel LIKE '$inputSearch%'

                                        OR CONCAT('Grade ', GradeLevel) LIKE '$inputSearch'
                                        OR CONCAT('Grade ', GradeLevel) LIKE '%$inputSearch%'
                                        OR CONCAT('Grade ', GradeLevel) LIKE '%$inputSearch'
                                        OR CONCAT('Grade ', GradeLevel) LIKE '$inputSearch%'

                                        OR SectionName LIKE '$inputSearch'
                                        OR SectionName LIKE '%$inputSearch%'
                                        OR SectionName LIKE '%$inputSearch'
                                        OR SectionName LIKE '$inputSearch%'

                                        OR AdviserName LIKE '$inputSearch'
                                        OR AdviserName LIKE '%$inputSearch%'
                                        OR AdviserName LIKE '%$inputSearch'
                                        OR AdviserName LIKE '$inputSearch%'

                                        OR AdviserSurname LIKE '$inputSearch'
                                        OR AdviserSurname LIKE '%$inputSearch%'
                                        OR AdviserSurname LIKE '%$inputSearch'
                                        OR AdviserSurname LIKE '$inputSearch%'

                                        OR AdviserTitle LIKE '$inputSearch'
                                        OR AdviserTitle LIKE '%$inputSearch%'
                                        OR AdviserTitle LIKE '%$inputSearch'
                                        OR AdviserTitle LIKE '$inputSearch%'

                                        OR CONCAT(AdviserTitle, '. ', AdviserName, ' ', AdviserSurname) LIKE '$inputSearch'
                                        OR CONCAT(AdviserName, ' ', AdviserSurname) LIKE '$inputSearch'
                                        OR CONCAT(AdviserTitle, '. ', AdviserName) LIKE '$inputSearch'
                                        OR CONCAT(AdviserTitle, '. ', AdviserSurname) LIKE '$inputSearch'

                                        OR CONCAT(AdviserTitle, '. ', AdviserName, ' ', AdviserSurname) LIKE '%$inputSearch%'
                                        OR CONCAT(AdviserName, ' ', AdviserSurname) LIKE '%$inputSearch%'
                                        OR CONCAT(AdviserTitle, '. ', AdviserName) LIKE '%$inputSearch%'
                                        OR CONCAT(AdviserTitle, '. ', AdviserSurname) LIKE '%$inputSearch%'

                                        OR CONCAT(AdviserTitle, '. ', AdviserName, ' ', AdviserSurname) LIKE '%$inputSearch'
                                        OR CONCAT(AdviserName, ' ', AdviserSurname) LIKE '%$inputSearch'
                                        OR CONCAT(AdviserTitle, '. ', AdviserName) LIKE '%$inputSearch'
                                        OR CONCAT(AdviserTitle, '. ', AdviserSurname) LIKE '%$inputSearch'

                                        OR CONCAT(AdviserTitle, '. ', AdviserName, ' ', AdviserSurname) LIKE '$inputSearch%'
                                        OR CONCAT(AdviserName, ' ', AdviserSurname) LIKE '$inputSearch%'
                                        OR CONCAT(AdviserTitle, '. ', AdviserName) LIKE '$inputSearch%'
                                        OR CONCAT(AdviserTitle, '. ', AdviserSurname) LIKE '$inputSearch%'

                                        ORDER BY GradeLevel ASC, SectionName ASC";

        } else {
            $sql = "SELECT * FROM section_list ORDER BY GradeLevel ASC, SectionName ASC";
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