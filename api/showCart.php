<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION['user_id'])) {
        try {
            $sql = "SELECT name,price,photo_path FROM products JOIN cart ON products.id = cart.product_id 
                WHERE cart.user_id = :user_id";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([
                'user_id' => $_SESSION['user_id']
            ])) {
                $products = $stmt->fetchAll();

                res('success', 200, 'Products fetch successfully', $products);
            } else {
                res('error', 500, 'Something went wrong on the server');
            }
        } catch (PDOException $e) {
            res('error', 500, 'Something went wrong on the server');
        }
    } else {
        if (isset($_COOKIE['cart'])) {
            $product_ids = json_decode($_COOKIE['cart'], true);
            $products = $product_ids['product_id'];
            $placeholders;
            if (!is_array($products)) {
                $products = [$products];
            } 

            $placeholders = implode(',', array_fill(0, count($products), '?'));

            try {
                $sql = "SELECT name,price,photo_path FROM products WHERE id IN ($placeholders)";

                $stmt = $conn->prepare($sql);
                if ($stmt->execute($products)) {
                    $products = $stmt->fetchAll();

                    res('success', 200, 'Products fetch successfully', $products);
                } else {
                    res('error', 500, 'Something went wrong on the server');
                }
            } catch (PDOException $e) {
                res('error', 500, 'Something went wrong on the server');
            }
        } else {
            res('success', 200, 'Cart is empty');
        }
    }
} else {
    res('error', 405, 'Method not allowed');
}
