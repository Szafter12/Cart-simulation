<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $sql = "SELECT * from products";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            $products = $stmt->fetchAll();
            res('success', 200, 'Data successfuly fetch', $products);
        } else {
            res('error', 500, 'Something went wrong on the server');
        }
    } catch (PDOException $e) {
        res('error', 500, 'Something went wrong on the server');
    }
} else {
    res('error', 405, 'Method not allowed');
}
