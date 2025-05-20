<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION['user_id'])) {
        res('success', 'User is logged in', [], 200);
    } else {
        res('error', 'User unknow', [], 200);
    }
}