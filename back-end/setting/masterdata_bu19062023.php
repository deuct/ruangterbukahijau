<?php
session_start();

require("./environment.php");
require("./back-end/sys/connection.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;
$data = isset($_POST['data']) ? json_encode($_POST['data']) : null;

if($data !== null) {
    $data = json_decode($data);
}

if(isset($action)) {
    if($action == 'addMasterData') {
        addMasterData($conn, $baseURL, $data);
    } else if ($action == 'getMasterDataList'){
        getMasterDataList($conn, $baseURL);
    } else if ($action == 'getMasterData') {
        getMasterData($conn, $baseURL, $data);
    } else if ($action == 'editMasterData') {
        editMasterData($conn, $baseURL, $data);
    } else if ($action == 'deleteMasterData') {
        deleteMasterData($conn, $baseURL, $data);
    }
}

function addMasterData($conn, $baseURL, $data) {
    $responseObj = new stdClass();
    $dateNow = date("Y-m-d");
    $superadmin = "superadmin";

    $masterdataCode = $data->masterdataCode;
    $masterdataName = $data->masterdataName;
    $masterdataDesc = $data->masterdataDesc;

    $qGetCode = "SELECT masterdata_code FROM masterdata WHERE masterdata_code = ?";
    $stmt = $conn->prepare($qGetCode);
    $stmt->bind_param("s", $masterdataCode);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $responseObj->status = "failed";
        $responseObj->msg = "Master data code already exist!. Please use another code";
        $responseJSON = json_encode($responseObj);
        echo $responseJSON;
    }

    $qInsertMasterData = "INSERT INTO masterdata (masterdata_code, masterdata_name, masterdata_desc, created_at, created_by, modified_at, modified_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($qInsertMasterData);
    $stmt->bind_param("sssssss", $masterdataCode, $masterdataName, $masterdataDesc, $dateNow, $superadmin, $dateNow, $superadmin);
    $stmt->execute();

    if($stmt) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully insert new masterdata";
        $responseJSON = json_encode($responseObj);
        echo $responseJSON;
    }
}

function getMasterDataList($conn, $baseURL) {
    $responseObj = new stdClass();

    $qGetMasterData = "SELECT masterdata_code, masterdata_name, masterdata_desc FROM masterdata ORDER BY created_at DESC";

    $result = $conn->query($qGetMasterData);
    
    if($result->num_rows > 0) {
        $resultArr = array();
        while($row = mysqli_fetch_assoc($result)) {
            $resultArr[] = $row;
        }

        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}
function getMasterData($conn, $baseURL, $data) {
    $responseObj = new stdClass();
    $masterdataCode = $data->masterdataCode;

    $qGetMasterData = "SELECT masterdata_code, masterdata_name, masterdata_desc FROM masterdata WHERE masterdata_code = ?";

    $stmt = $conn->prepare($qGetMasterData);
    $stmt->bind_param("s", $masterdataCode);
    $stmt->execute();
    $result = $stmt->get_result();
    // $result = $result->fetch_all(MYSQLI_ASSOC);

    $resultArr = array();
    foreach($result as $key => $rs){
        $resultArr[] = $rs;
    }

    if(count($resultArr) > 0) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully fetch list data";
        $responseObj->data = $resultArr;
        $responseJSON = json_encode($responseObj);
    
        echo $responseJSON;
    } else {
        $responseObj->status = "failed";
        $responseObj->msg = "Failed get the data";
        $responseJSON = json_encode($responseObj);
    
        echo $responseJSON;
    }
}

function editMasterData($conn, $baseURL, $data) {
    $responseObj = new stdClass();
    $masterdataCode = $data->masterdataCode;
    $masterdataName = $data->masterdataName;
    $masterdataDesc = $data->masterdataDesc;
    $dateNow = date("Y-m-d");
    
    $qUpdateMasterData = "UPDATE masterdata SET masterdata_name = ?, masterdata_desc = ?, modified_at = ? WHERE masterdata_code = ?";
    $stmt = $conn->prepare($qUpdateMasterData);
    $stmt->bind_param("ssss", $masterdataName, $masterdataDesc, $dateNow, $masterdataCode);
    $stmt->execute();

    if($stmt) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully edit masterdata";
        $responseJSON = json_encode($responseObj);
        echo $responseJSON;
    }
}

function deleteMasterData($conn, $baseURL, $data) {
    $responseObj = new stdClass();
    $masterdataCode = $data->masterdataCode;

    $qDeleteMasterData = "DELETE FROM masterdata WHERE masterdata_code = ?";
    $stmt = $conn->prepare($qDeleteMasterData);
    $stmt->bind_param("s", $masterdataCode);
    $stmt->execute();

    if($stmt) {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully delete masterdata";
        $responseJSON = json_encode($responseObj);
        echo $responseJSON;
    }
}