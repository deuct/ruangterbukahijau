<?php
session_start();

require("./environment.php");
require("./back-end/sys/connection.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;
$data = isset($_POST['data']) ? json_encode($_POST['data']) : null;

if ($data !== null) {
    $data = json_decode($data);
}

if (isset($_POST['action'])) {
    if ($_POST['action'] == "loginAuth") {
        loginAuth($conn, $baseURL, $data);
    };
}

function loginAuth($conn, $baseURL, $data)
{
    $responseObj = new stdClass();

    $username = $data->username;
    $password = $data->password;
    $DBusername = "";
    $DBpassword = "";
    $DBNamaLengkap = "";
    $DBRole = "";

    if ($username === null or $password === null) {
        $responseObj->status = "failed";
        $responseObj->msg = "Username or password is empty!";

        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }

    $qGetUser = "SELECT us.username, us.password, ui.nama_lengkap, us.role FROM users us LEFT JOIN user_info ui ON ui.username = us.username WHERE us.username = ?";
    $stmt = $conn->prepare($qGetUser);

    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->store_result();
    // $userData = $stmt->store_result();

    // foreach ($userData as $ud) {
    //     $fullname = $ud['nama_lengkap'];
    // }

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($DBusername, $DBpassword, $DBNamaLengkap, $DBRole);
        $stmt->fetch();

        if (password_verify($password, $DBpassword)) {
            session_regenerate_id();

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $DBNamaLengkap;
            $_SESSION['role'] = $DBRole;
            $_SESSION['berhasil'] = true;

            $responseObj->status = "success";
            $responseObj->msg = "Successfully Login";

            $responseJSON = json_encode($responseObj);

            echo $responseJSON;
        } else {
            $responseObj->status = "failed";
            $responseObj->msg = "Incorrect username and/or password!";

            $responseJSON = json_encode($responseObj);

            echo $responseJSON;
        }
    } else {
        $responseObj->status = "failed";
        $responseObj->msg = "Incorrect username and/or password!";

        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }

    $stmt->close();
}
