<?php

require_once 'db_conn.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $sql = "SELECT * from products";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            $products = $stmt->fetchAll();
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'data' => $products
            ]);
            exit;
        } else {
            serverError();
        }
    } catch (PDOException $e) {
        serverError();
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => "Nieobsługiwana metoda żądania"
    ]);
    exit;
}

function serverError()
{
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => "Błąd serwera spróbuj później"
    ]);
    exit;
}
