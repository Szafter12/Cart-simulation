<?php

require_once "db_conn.php";
require_once "utils.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');

session_start();

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data['product_id']) {
        res('error', 400, 'product id is missing');
    }

    $product_id = $data['product_id'];

    if (isset($_SESSION['user_id'])) {
        try {
            $sql = "DELETE from cart WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([
                'user_id' => $_SESSION['user_id'],
                'product_id' => $product_id
            ])) {
                res('success', 200, "Product successfully remove from cart");
            } else {
                res("error", 500, "Someting went wrong");
            }
        } catch (PDOException $e) {
            res("error", 500, "Something went wrong");
        }
    } else {
        if ($_COOKIE['cart']) {
            $product_ids = json_decode($_COOKIE['cart'], true);
            $product_ids = $product_ids['product_id'];

            if (is_array($product_ids)) {
                $product_ids = array_filter($product_ids, fn($val) => $val != $product_id);
                $cart = [
                    'product_id' => $product_ids
                ];
                addCookie($cart);
            } else {
                setcookie('cart', '', time() - 3600, '/');
                unset($_COOKIE['cart']);
            }
            
            res('success', 200, 'Succesfully remove from cart');
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
