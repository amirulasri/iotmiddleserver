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

$listdevicearray = array();
if(accessByToken($conn, $token, $publicKey)){
    $actionsqlstmt = $conn->prepare("SELECT `id`, `iotname`, `devicetype`, `gpionumber` FROM `iotdevices` WHERE `users` = ?");
    $actionsqlstmt->bind_param("s", $username);
    $username = getUsername($conn, $token, $publicKey);
    $actionsqlstmt->execute();
    $result = $actionsqlstmt->get_result();

    while ($loopdata = $result->fetch_array()) {
        $eachdevice = array("id" => $loopdata[0], "name" => $loopdata[1], "devicetype" => $loopdata[2], "gpionumber" => $loopdata[3]);
        array_push($listdevicearray, $eachdevice);
    }
    echo json_encode($listdevicearray);
}else{
    echo json_encode($listdevicearray);
}