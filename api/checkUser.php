<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION['user_id'])) {
        res('success', 200, 'User is logged in');
    } else {
        res('error', 200, 'User unknow');
    }
} else {
    res('error', 405, 'Method not allowed');
}
