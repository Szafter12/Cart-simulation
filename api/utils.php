<?php

function res($status, $code, $msg = '', $data = []): void {
    http_response_code($code);
    echo json_encode([
        'status' => $status,
        'message' => $msg,
        'data' => $data
    ]);
    exit;
}

function init_session() {
    ini_set("session.gc_maxlifetime", 3600 * 24);
    ini_set("session.cookie_lifetime", 3600 * 24);
    ini_set("session.cookie_httponly", 1);
    session_start();
}