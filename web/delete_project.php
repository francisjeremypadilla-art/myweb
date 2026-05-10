<?php

$conn = new mysqli("localhost", "root", "", "portfolio_db");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM projects WHERE id=$id");

$row = $result->fetch_assoc();

if(file_exists($row['image_path'])) {
    unlink($row['image_path']);
}

$conn->query("DELETE FROM projects WHERE id=$id");

header("Location: index.php");

?>