<?php

require_once "db_conn.php";
require_once "utils.php";

init_session();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

$cart = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents("php://input");
    $data = json_decode($data, true);
    $value = ['product_id' => $data['id']];

    if (empty($_SESSION['user_id'])) {
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

        res('success', 200, 'Product added to the cart');
    } else {
        try {
            $user_id = $_SESSION['user_id'];
            $product_id = $data['id'];

            $sql = "INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([
                'user_id' => $user_id,
                'product_id' => $product_id
            ])) {
                res('success', 200, "Successfully added product to the cart");
            } else {
                res('error', 400, 'Adding product to the cart failed');
            }
        } catch (PDOException $e) {
            res('error', 500, $e);
        }
    }
} else {
    res('error', 405, 'Method not allowed');
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
