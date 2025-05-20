<?php
require_once "db_conn.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$cart = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents("php://input");
    $data = json_decode($data, true);
    $value = ['product_id' => $data['id']];

    if (empty($_SESSION['name'])) {
        if (empty($_COOKIE['cart'])) {
            addCookie($value);
        } else {
            $last_cart = json_decode($_COOKIE['cart'], true);
            $ids = $last_cart['product_id'];

            if (is_array($ids)) {
                array_push($ids, $data['id']);
                $cart = [
                    'product_id' => $ids
                ];
            } else {
                $cart = [
                    'product_id' => [$ids, $data['id']]
                ];
            }

            addCookie($cart);
        }

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => "Produkt dodany do koszyka"
        ]);
        exit;
    }
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => "Błąd serwera spróbuj później"
    ]);
    exit;
}

function addCookie($data)
{
    setcookie(
        'cart',
        json_encode($data),
        time() + (3600 * 24 * 7),
        '/',
        '',
        false,
        true
    );
}
