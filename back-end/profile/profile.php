<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require("./environment.php");
require("./back-end/sys/connection.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;
$data = isset($_POST['data']) ? json_encode($_POST['data']) : null;

if ($data !== null) {
    $data = json_decode($data);
}

if (isset($action)) {
    if ($action == 'getProfile') {
        getProfile($conn, $baseURL, $data);
    }
}

function getProfile($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $username = $data->username;

    $qGetProfile = "SELECT us.email, us.username, ui.nama_lengkap, ui.list_favourite, ui.user_photo, ui.address, ui.rt, ui.rw, ui.kecamatan, ui.kelurahan FROM users us LEFT JOIN user_info ui ON ui.username = us.username WHERE us.username = '$username'";
    $stmt = $conn->prepare($qGetProfile);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultArr = array();
    foreach ($result as $key => $rs) {
        $resultArr[] = $rs;
    }

    if (count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}
