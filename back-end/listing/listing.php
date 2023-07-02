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
    if ($action == 'generateId') {
        generateId($conn, $baseURL);
    }
}

function generateId($conn, $baseURL)
{
    // Format : TMYYYYMMDDXXXX
    $responseObj = new stdClass();
    $dateNow = date("Ymd");
    $dateTimeNow = date("Y-m-d H:i:s");
    $newId = "";
    $lastId = "";
    $superadmin = "superadmin";

    $qGetLastId = "SELECT kode_rth FROM detail_rth ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($qGetLastId);
    $stmt->execute();
    $result = $stmt->get_result();

    foreach ($result as $rs) {
        $lastId = $rs["kode_rth"];
    }

    if ($lastId === "") {
        $lastId = "TM" . $dateNow . "0001";
    }

    $noUrut = substr($lastId, 10, 4);
    $noUrut = intval($noUrut) + 1;

    if (strlen($noUrut) === 1) {
        $noUrut = (string) $noUrut;
        $newId = "000" . $noUrut;
    } else if (strlen($noUrut) === 2) {
        $noUrut = (string) $noUrut;
        $newId = "00" . $noUrut;
    } else if (strlen($noUrut) === 3) {
        $noUrut = (string) $noUrut;
        $newId = "0" . $noUrut;
    } else if (strlen($noUrut) === 4) {
        $noUrut = (string) $noUrut;
        $newId = $noUrut;
    }

    $newId = "TM" . $dateNow . $newId;

    $qInsertDetail = "INSERT INTO detail_rth (kode_rth, created_at, created_by, modified_at, modified_by) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($qInsertDetail);
    $stmt->bind_param("sssss", $newId, $dateTimeNow, $superadmin, $dateTimeNow, $superadmin);
    $stmt->execute();

    if (strlen($newId) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $newId;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}
