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

if ($uri === "/myweb/web/save_project.php/update_project") {
    header('Content-Type: application/json');

    if($method !== "POST") {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }

    $project_data = json_decode($_POST['project_data'], true);

    if(!$project_data) {
        http_response_code(400);
        echo json_encode(['error' => 'bad request']);
        exit;
    }

    $id = $project_data['id'];
    $title = $project_data['title'];
    $description = $project_data['description'];
    $date = $project_data['date'];

    $stmt = $conn->prepare("UPDATE projects SET title=?, description=?, date=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $description, $date, $id);
    $stmt->execute();

    http_response_code(200);
    echo json_encode(["message" => "updated one", "status" => 200]);

    $conn->close();
    exit;
}

if ($uri === "/myweb/web/save_project.php/delete_project") {
    header('Content-Type: application/json');

    if ($method !== "POST") {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }

    // Read raw JSON body
    $project_data = json_decode(file_get_contents("php://input"), true);

    if (!$project_data || !isset($project_data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Bad request']);
        exit;
    }

    $id = (int)$project_data['id'];

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            "message" => "Deleted successfully",
            "status" => 200
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "error" => "Delete failed"
        ]);
    }

    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(["message" => "why?"]);
?>