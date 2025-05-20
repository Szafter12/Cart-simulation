<?php

require_once 'db_conn.php';
require_once 'utils.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

init_session();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($repeat_password)) {
        res('error', 400, 'All fields require');
    }

    if ($password !== $repeat_password) {
        res('error', 400, 'Passwords must be the same');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        res('error', 400, 'provide valid email');
    }

    $hash_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT IGNORE INTO users (name, surname, email, password) VALUES (:name, :surname, :email, :password)";
        $stmt = $conn->prepare($sql);

        if ($stmt->execute([
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'password' => $hash_password
        ])) {
            if ($stmt->rowCount() > 0) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $conn->lastInsertId();
                $_SESSION['name'] = $name;
                $_SESSION['surname'] = $surname;
                $_SESSION['email'] = $email;

                res('success', 200, 'User successfuly register');
            } else {
                res("error", 400, "User already exist");
            }
        } else {
            res('error', 500, 'Error while adding new user');
        }
    } catch (PDOException $e) {
        res('error', 500, 'Error while adding new user');
    }
}
