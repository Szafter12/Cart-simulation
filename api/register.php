<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($repeat_password)) {
        res('error', 'All fields require', [], 200);
    }

    if ($password !== $repeat_password) {
        res('error', 'Passwords must be the same', [], 200);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        res('error', 'provide valid email', [], 200);
    }

    $hash_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT IGNORE INTO users (name, surname, email, password) VALUES (:name, :surname, :email, :password)";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => $password
        ])) {
            if ($stmt->rowCount() > 0) {
                $_SESSION['user_id'] = $conn->lastInsertId();
                $_SESSION['name'] = $name;
                $_SESSION['surname'] = $surname;
                $_SESSION['email'] = $email;

                res('success', 'User successfuly register', [], 200);
            } else {
                res("error", "User already exist", [], 200);
            }
        } else {
            res('error', 'Error while adding new user', [], 500);
        }
    } catch (PDOException $e) {
        res('error', 'Error while adding new user', [], 500);
    }
}
