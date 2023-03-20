<?php
require_once('vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function login($username, $password, $conn, $privateKey)
{
    // Prepare the SQL statement to check the username and password
    $loginsqlstmt = $conn->prepare("SELECT `password` FROM `users` WHERE `username` = ?");
    $loginsqlstmt->bind_param("s", $username);
    $loginsqlstmt->execute();
    $result = $loginsqlstmt->get_result();

    // Check if the username was found and the password is correct
    if ($result->num_rows > 0 && password_verify($password, $result->fetch_assoc()['password'])) {
        $issuedAt   = time();
        $notBefore  = $issuedAt;  // Adding 10 seconds
        // $expire     = $notBefore + 60 * 60; // Adding 60 seconds
        $expire     = strtotime('+3 months', $notBefore); // Adding 3 months
        $serverName = 'amirulasri.com';

        $data = array(
            'iat'  => $issuedAt,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => array(
                'username' => $username // Username
            ),
        );

        // Encode the token using the private key
        $jwt = JWT::encode($data, $privateKey, 'RS256');

        // Set the HTTP response headers
        header('Content-type: application/json');
        header('Authorization: Bearer ' . $jwt);
        echo json_encode(array("success" => true, 'token' => $jwt));
    } else {
        echo json_encode(array("success" => false, "desc" => "Invalid username or password"));
    }
}

function register($username, $password, $fullname, $conn, $privateKey)
{
    $securedpassword = password_hash($password, PASSWORD_DEFAULT);
    // Prepare the SQL statement to check the username and password
    $registersqlstmt = $conn->prepare("INSERT INTO `users`(`username`, `password`, `fullname`) VALUES (?,?,?)");
    $registersqlstmt->bind_param("sss", $username, $securedpassword, $fullname);
    $result = $registersqlstmt->execute();

    // Check if the username was found and the password is correct
    if ($result) {
        $issuedAt   = time();
        $notBefore  = $issuedAt;  // Adding 10 seconds
        // $expire     = $notBefore + 60 * 60; // Adding 60 seconds
        $expire     = strtotime('+3 months', $notBefore); // Adding 3 months
        $serverName = 'amirulasri.com';

        $data = array(
            'iat'  => $issuedAt,
            'iss'  => $serverName,
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => array(
                'username' => $username // Username
            ),
        );

        // Encode the token using the private key
        $jwt = JWT::encode($data, $privateKey, 'RS256');

        // Set the HTTP response headers
        header('Content-type: application/json');
        header('Authorization: Bearer ' . $jwt);
        echo json_encode(array("success" => true, 'token' => $jwt));
    } else {
        echo json_encode(array("success" => false, "desc" => "Invalid username or password"));
    }
}

function accessByToken($conn, $token, $publicKey)
{
    try {
        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
        $arraydatauser = (array) $decoded;
        if (($arraydatauser["iat"] <= time() && $arraydatauser["exp"] >= time())) {
            $userdbsqlstmt = $conn->prepare("SELECT `username` FROM `users` WHERE `username` = ?");
            $userdbsqlstmt->bind_param("s", $arraydatauser["data"]->username);
            $userdbsqlstmt->execute();
            $userdbsqlstmt->store_result();
            if ($userdbsqlstmt->num_rows < 1) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function getUsername($conn, $token, $publicKey)
{
    try {
        $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
        $arraydatauser = (array) $decoded;
        if (($arraydatauser["iat"] <= time() && $arraydatauser["exp"] >= time())) {
            $userdbsqlstmt = $conn->prepare("SELECT `username` FROM `scheduleraccount` WHERE `username` = ?");
            $userdbsqlstmt->bind_param("s", $arraydatauser["data"]->username);
            $userdbsqlstmt->execute();
            $userdbsqlstmt->store_result();
            if ($userdbsqlstmt->num_rows < 1) {
                return "";
            }
        } else {
            return "";
        }
        return $arraydatauser["data"]->username;
    } catch (Exception $e) {
        return "";
    }
}
