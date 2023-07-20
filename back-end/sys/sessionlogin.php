<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: ' . $baseURL . '/404');
} else {
    $username = $_SESSION['username'];
    $fullname = $_SESSION['fullname'];
    $role = $_SESSION['role'];
}
