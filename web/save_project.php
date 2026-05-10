<?php

$conn = new mysqli("localhost", "root", "", "portfolio_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        $imageName = time() . "_" . $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        $targetFolder = "image/";

        if(!is_dir($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }

        $targetFile = $targetFolder . basename($imageName);

        if(move_uploaded_file($tmpName, $targetFile)) {

            $stmt = $conn->prepare(
                "INSERT INTO projects(title, description, image_path, date)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $title,
                $description,
                $targetFile,
                $date
            );

            $stmt->execute();

            header("Location: index.php");
            exit();

        } else {
            echo "Failed to upload image.";
        }

    } else {
        echo "Image upload error.";
    }
}
?>