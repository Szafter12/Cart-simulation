<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

init_session();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        res("error", 400, "All fields require");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        res("error", 422, "Provide valid email address");
    }

    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([
            'email' => $email
        ])) {
            $user = $stmt->fetch();

            if (!$user) {
                res("error", 422, "User with this email didnt exist");
            }

            if (!password_verify($password, $user['password'])) {
                res("error", 422, "Wrong Email or password");
            }

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['surname'] = $user['surname'];
            $_SESSION['email'] = $user['email'];

            if (isset($_COOKIE['cart'])) {
                addFromCookie($_SESSION['user_id'], $conn);
            }

            res('success', 200, 'User successfully logged in');
        } else {
            res("error", 500, "Something went wrong while loggin");
        }
    } catch (PDOException $e) {
        res("error", 500, "Something went wrong on the server");
    }
} else {
    res('error', 405, 'Method not allowed');
}

function addFromCookie($user, $conn)
{
    $product_ids = json_decode($_COOKIE['cart'], true);
    $products = $product_ids['product_id'];

    if (!is_array($products)) {
        try {
            $sql = "INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)";
            $stmt = $conn->prepare($sql);

            if ($stmt->execute([
                'user_id' => $user,
                'product_id' => $products
            ])) {
                setcookie('cart', '', time() - 3600, '/');
                unset($_COOKIE['cart']);
            }
        } catch (PDOException $e) {
            res('error', 500, "SOmething went wrong");
        }
    } else {
        try {
            foreach ($products as $product) {
                $sql = "INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'user_id' => $user,
                    'product_id' => $product
                ]);
            }
            
            setcookie('cart', '', time() - 3600, '/');
            unset($_COOKIE['cart']);
        } catch (PDOException $e) {
            res('error', 500, "Something went wrong");
        }
    }
}
