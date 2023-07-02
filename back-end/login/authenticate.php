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

    if ($username === null or $password === null) {
        $responseObj->status = "failed";
        $responseObj->msg = "Username or password is empty!";

        $responseJSON = json_encode($responseObj);

        echo $responseJSON;
    }

    $qGetUser = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($qGetUser);


    $stmt->bind_param("s", $username);


    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($DBusername, $DBpassword);
        $stmt->fetch();

        if (password_verify($password, $DBpassword)) {
            session_regenerate_id();

            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
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
