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
    echo json_encode(array("success" => false, "desc" => "Missing request body"));
    exit;
}
$data = json_decode($request_body);
$token = $data->token;
$iotname = $data->devicename;
$devicetype = $data->devicetype;
$gpionumber = $data->gpiopin;
$devicedesc = $data->description;
$deviceid = $data->id;

if (accessByToken($conn, $token, $publicKey)) {
    $actionsqlstmt = $conn->prepare("UPDATE `iotdevices` SET `devicetype`=?,`iotname`=?,`gpionumber`=?,`devicedesc`=? WHERE `id`=? AND `users`=?");
    $actionsqlstmt->bind_param("ssisss", $devicetype, $iotname, $gpionumber, $devicedesc, $deviceid, $username);
    $username = getUsername($conn, $token, $publicKey);
    $result = $actionsqlstmt->execute();

    if ($result) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false, 'desc' => $conn->error));
    }
} else {
    echo json_encode(array("success" => false, 'desc' => "Invalid authorization"));
}
