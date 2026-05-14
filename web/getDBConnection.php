<?php

function getDBConnection() {
    $host = "localhost";
    $db   = "portfolio_db";
    $user = "root";
    $pass = "1234";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    return $conn;
}