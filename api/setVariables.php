<?php
/*
header("Cache-Control: no cache");
session_cache_limiter("private_no_expire");
*/

ob_start();
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

$questions = $_SESSION['questionString'];


$response = $questions;
echo ("Hello from server nasa setvariable ako: $response");

?>
