<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'getDBconnection.php';

$conn = getDBConnection();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === "/myweb/web/save_project.php/save_project") {

    if($method !== "POST") {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }

    $project_data = json_decode($_POST['project_data'], true);
    $images = $_FILES['images'] ?? null;
    $fileName = $images['name'];

    $tmp = $images['tmp_name'];
 
    $title = $project_data['title'];
    $description = $project_data['description'];
    $date = $project_data['date'];
    $imageUrl = '/images/' . $fileName;


    if(!$project_data) {
        http_response_code(400);
        echo json_encode(['error' => 'bad request']);
        exit;
    }
      
    $targetPath = __DIR__ . '/images/' . $fileName;

    move_uploaded_file($tmp, $targetPath);

    $conn = getDBConnection();

    $stmt = $conn->prepare("INSERT INTO projects (title, description, date, imageUrl) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $date, $imageUrl);
    $stmt->execute();

    http_response_code(201);
    echo json_encode(["message" => "created one", "status" => 201]);

    $conn->close();

    exit;
}

if ($uri === "/myweb/web/save_project.php/get_projects") {
    header('Content-Type: application/json');

    $result = $conn->query("SELECT * FROM projects ORDER BY id DESC");

    $projects = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {

            $projects[] = [
                "id" => $row["id"],
                "title" => $row["title"],
                "description" => $row["description"],
                "date" => $row["date"],
                "imageUrl" => $row["imageUrl"]
            ];
        }
    }

    echo json_encode($projects);

    $conn->close();
    exit;

}

echo json_encode(["message" => "why?"]);
?>