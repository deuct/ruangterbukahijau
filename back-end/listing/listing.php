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
    } else if ($action == 'getAllTaman') {
        getAllTaman($conn, $baseURL);
    } else if ($action == 'deleteDetailTaman') {
        deleteDetailTaman($conn, $baseURL, $data);
    } else if ($action == 'getSearchTaman') {
        getSearchTaman($conn, $baseURL, $data);
    }
}

function getSearchTaman($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $searchValue = $data->searchValue;

    $splitValue = explode(" ", $searchValue);
    $categoryValue = $splitValue[0];

    // echo $searchValue;

    if ($categoryValue == "taman" || $categoryValue == "kebun") {
        // echo "here 1";
        $searchValue = substr($searchValue, 6);
        $qGetSearchedTaman = "SELECT detail.kode_rth, detail.nama, detail.kapasitas, detail.luas_area, kategori.nama_kategori,
        CASE WHEN detail.status = '0' THEN 'Close'
        WHEN detail.status = '1' THEN 'Open'
        WHEN detail.status = '2' THEN 'Under Maintenance'
        END AS status, detail.kota, detail.propinsi, detail.kecamatan, detail.kelurahan, detail.lst_gambar, co.kordinat_1, co.kordinat_2, detail.deskripsi FROM detail_rth detail LEFT JOIN kordinat_rth co ON co.kode_kordinat = detail.kode_kordinat AND co.kode_taman = detail.kode_rth LEFT JOIN kategori_rth kategori ON kategori.kode_kategori = detail.kode_kategori
        WHERE kategori.nama_kategori LIKE '%$categoryValue%' AND detail.kota LIKE '%$searchValue%'";
        $stmt = $conn->prepare($qGetSearchedTaman);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // echo "here 2";
        $qGetSearchedTaman = "SELECT detail.kode_rth, detail.nama, detail.kapasitas, detail.luas_area, 
        CASE WHEN detail.status = '0' THEN 'Close'
        WHEN detail.status = '1' THEN 'Open'
        WHEN detail.status = '2' THEN 'Under Maintenance'
        END AS status, detail.kota, detail.propinsi, detail.kecamatan, detail.kelurahan, detail.lst_gambar, co.kordinat_1, co.kordinat_2, detail.deskripsi FROM detail_rth detail LEFT JOIN kordinat_rth co ON co.kode_kordinat = detail.kode_kordinat AND co.kode_taman = detail.kode_rth
        WHERE detail.nama LIKE '%$searchValue%' OR detail.kota LIKE '%$searchValue%' OR detail.kecamatan LIKE '%$searchValue%' OR detail.kelurahan LIKE '%$searchValue%'";
        $stmt = $conn->prepare($qGetSearchedTaman);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $resultArr = array();
    foreach ($result as $key => $rs) {
        $resultArr[] = $rs;
    }

    if (count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    } else {
        $responseObj->status = "failed";
        $responseObj->msg = "Failed Search Data";
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}

function deleteDetailTaman($conn, $baseURL, $data)
{
    $responseObj = new stdClass();
    $kodeTaman = $data->kodeTaman;

    // $qGetKordinatId = "SELECT kode_kordinat FROM detail_rth WHERE kode_rth = '$kodeTaman'";
    // $stmt = $conn->prepare($qGetKordinatId);
    // $stmt->execute();
    // $kordinatId = $stmt->get_result();

    // foreach ($kordinatId as $ki) {
    //     $kordinatId = $ki['kode_kordinat'];
    // }

    $qDeleteKordinat = "DELETE FROM kordinat_rth WHERE kode_taman = '$kodeTaman'";
    $stmt = $conn->prepare($qDeleteKordinat);
    $stmt->execute();

    $qDeleteDetail = "DELETE FROM detail_rth WHERE kode_rth = '$kodeTaman'";
    $stmt = $conn->prepare($qDeleteDetail);
    $stmt->execute();

    $responseObj->status = "success";
    $responseObj->msg = "Successfully delete data";
    $responseObj->kodeTaman = $kodeTaman;
    $responseJSON = json_encode($responseObj);

    echo $responseJSON;
}

function getAllTaman($conn, $baseURL)
{
    $responseObj = new stdClass();

    $qGetListTaman = "SELECT detail.kode_rth, detail.nama, detail.kapasitas, detail.luas_area, 
    CASE WHEN detail.status = '0' THEN 'Close'
    WHEN detail.status = '1' THEN 'Open'
    WHEN detail.status = '2' THEN 'Under Maintenance'
    END AS status, detail.kota, detail.propinsi, detail.kecamatan, detail.kelurahan, detail.lst_gambar, co.kordinat_1, co.kordinat_2, detail.deskripsi FROM detail_rth detail LEFT JOIN kordinat_rth co ON co.kode_kordinat = detail.kode_kordinat AND co.kode_taman = detail.kode_rth";
    $stmt = $conn->prepare($qGetListTaman);
    $stmt->execute();
    $result = $stmt->get_result();

    $resultArr = array();
    foreach ($result as $key => $rs) {
        $resultArr[] = $rs;
    }

    if (count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
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
