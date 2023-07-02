<?php
require_once("./back-end/sys/connection.php");
require_once("./environment.php");

$responseObj = new stdClass();

$password = isset($_POST['password']) ? $_POST['password'] : null;
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : null;

if ($password !== $repassword) {
    $responseObj->status = "failed";
    $responseObj->msg = "password not match!";

    $responseJSON = json_encode($responseObj);

    echo $responseJSON;
} else {
    $username = filter_input(INPUT_POST, 'username', FILTER_DEFAULT);
    $name = filter_input(INPUT_POST, 'name', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $address = filter_input(INPUT_POST, 'address', FILTER_DEFAULT);
    $kecamatan = filter_input(INPUT_POST, 'kecamatan', FILTER_DEFAULT);
    $kelurahan = filter_input(INPUT_POST, 'kelurahan', FILTER_DEFAULT);
    $rt = filter_input(INPUT_POST, 'rt', FILTER_DEFAULT);
    $rw = filter_input(INPUT_POST, 'rw', FILTER_DEFAULT);
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $repassword = filter_input(INPUT_POST, 'repassword', FILTER_DEFAULT);
    $dateNow = date("Y-m-d");
    $superadmin = "superadmin";
    $role = "user";

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    $counterQuery = 0;

    $qInsertUser = "INSERT INTO users (username, password, email, role, created_at, created_by, modified_at, modified_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($qInsertUser);
    $stmt->bind_param("ssssssss", $username, $password, $email, $role, $dateNow, $superadmin, $dateNow, $superadmin);
    $stmt->execute();
    if($stmt) {
        $counterQuery += 1;
    } else {
        echo $stmt->errno;
    }

    $qInsertUserInfo =  "INSERT INTO user_info (username, nama_lengkap, address, RT, RW, kecamatan, kelurahan, created_at, created_by, modified_at, modified_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($qInsertUserInfo);
    $stmt->bind_param("sssssssssss", $username, $name, $address, $rt, $rw, $kecamatan, $kelurahan, $dateNow, $superadmin, $dateNow, $superadmin);
    $stmt->execute();
    if($stmt) {
        $counterQuery += 1;
    } else {
        echo $stmt->errno;
    }


    if ($counterQuery < 2) {
        $responseObj->status = "failed";
        $responseObj->msg = "There's an error while inserting the data.";

        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    } else {
        $responseObj->status = "success";
        $responseObj->msg = "Successfully registered. You will redirected to the login page";

        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }
}
