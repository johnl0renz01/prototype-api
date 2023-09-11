<?php 
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
 
include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();

$response = array();
$upload_dir = '../src/assets/uploads/';
$server_url = 'http://localhost:80/Prototype-Vite/my-project/src/assets';
 

switch($_SESSION['method']) {
    case "GET":
        $sql2 = "SELECT SectionImage FROM section_list 
                WHERE SectionName IS NULL OR SectionName = '' 
                ORDER BY SectionID DESC LIMIT 1";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        $response = $stmt2->fetchColumn();
        
        echo json_encode($response);
        break;

    case "POST":
        if($_FILES['avatar'])
        {
            $avatar_name = $_FILES["avatar"]["name"];
            $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
            $error = $_FILES["avatar"]["error"];
         
            if($error > 0){
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }else
            {
                //RANDOMIZED AND UNIQUE UPLOAD
                //$random_name = rand(1000,1000000)."-".$avatar_name;
                //$random_name = $avatar_name; // EDITED
                $random_name = strtolower($avatar_name); //NEW
                $upload_name = $upload_dir.strtolower($random_name); //EDITED
                //$upload_name = strtolower($random_name); // NEW
                $upload_name = preg_replace('/\s+/', '-', $upload_name);
             
                if(move_uploaded_file($avatar_tmp_name , $upload_name)) {
                    $response = array(
                        "status" => "success",
                        "error" => false,
                        "message" => "File uploaded successfully",
                        "url" => $server_url."/".$upload_name
                      );
                       
                    $host = "localhost"; 
                    $user = "root"; 
                    $password = ""; 
                    $dbname = "prototype_sfe"; 
                       
                    $con = mysqli_connect($host, $user, $password,$dbname);  
         
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
         
                    $sql2 = "SELECT SectionID FROM section_list 
                            WHERE SectionName IS NULL OR SectionName = '' 
                            ORDER BY SectionID DESC LIMIT 1";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->execute();
                    $response = $stmt2->fetchColumn();
                    $sql = "";

                    /* EDITED
                    if (strlen($response) > 0) {
                        $sql = "UPDATE section_list SET SectionImage = ('$upload_name') WHERE SectionName IS NULL OR SectionName = '' ORDER BY SectionID DESC LIMIT 1  "; 
                    } else {
                        $sql = "INSERT into section_list (SectionImage) values ('$upload_name')"; 
                    }
                    */

                    // NEW
                    if (strlen($response) > 0) {
                        $sql = "UPDATE section_list SET SectionImage = ('$random_name') WHERE SectionName IS NULL OR SectionName = '' ORDER BY SectionID DESC LIMIT 1  "; 
                    } else {
                        $sql = "INSERT into section_list (SectionImage) values ('$random_name')"; 
                    }

                    
                    mysqli_query($con,$sql);
                    

                    $output = "done";
                    echo json_encode($output);
           
                }else
                {
                    $response = array(
                        "status" => "error",
                        "error" => true,
                        "message" => "Error uploading the file!"
                    );
                }
            }
         
        }else{
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "No file was sent!"
            );
        }
         
        echo json_encode($response);
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
}



?>