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
$iddevice = $data->id;

$devicearray = array();
if(accessByToken($conn, $token, $publicKey)){
    $actionsqlstmt = $conn->prepare("SELECT `iotname`, `devicetype`, `gpionumber`, `devicedesc` FROM `iotdevices` WHERE `users` = ? AND `id` = ?");
    $actionsqlstmt->bind_param("si", $username, $iddevice);
    $username = getUsername($conn, $token, $publicKey);
    $actionsqlstmt->execute();
    $result = $actionsqlstmt->get_result();
    $datadevice = $result->fetch_array();
    $devicearray = array("name" => $datadevice[0], "devicetype" => $datadevice[1], "gpionumber" => $datadevice[2], "desc" => $datadevice[3]);
    echo json_encode($devicearray);
}else{
    echo json_encode($devicearray);
}