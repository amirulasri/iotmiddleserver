<?php
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
$username = $data->username;
$password = $data->password;
login($username, $password, $conn, $privateKey);
