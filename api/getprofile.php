<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require('config.php');
require('accesstoken.php');
$request_body = file_get_contents('php://input');
if (empty($request_body)) {
    echo json_encode(array("success"=>false, "desc" => "Missing request body"));
    exit;
}
$data = json_decode($request_body);
$token = $data->token;

$devicearray = array();
if(accessByToken($conn, $token, $publicKey)){
    $actionsqlstmt = $conn->prepare("SELECT `fullname` FROM `users` WHERE `username` = ?");
    $actionsqlstmt->bind_param("s", $username);
    $username = getUsername($conn, $token, $publicKey);
    $actionsqlstmt->execute();
    $result = $actionsqlstmt->get_result();
    $datadevice = $result->fetch_array();
    $devicearray = array("name" => $datadevice[0]);
    echo json_encode($devicearray);
}else{
    echo json_encode($devicearray);
}