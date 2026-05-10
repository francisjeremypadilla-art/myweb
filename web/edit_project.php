<?php

$conn = new mysqli("localhost", "root", "", "portfolio_db");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM projects WHERE id=$id");

$row = $result->fetch_assoc();

if(isset($_POST['update'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $conn->query("
        UPDATE projects
        SET
        title='$title',
        description='$description',
        date='$date'
        WHERE id=$id
    ");

    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Project</title>
    <link rel="stylesheet" href="responsive.css">
</head>
<body>

<div class="modal-content" style="margin: 100px auto;">

    <h2>Edit Project</h2>

    <form method="POST" class="form-box">

        <input
            type="text"
            name="title"
            value="<?php echo $row['title']; ?>"
            required
        >

        <input
            type="date"
            name="date"
            value="<?php echo $row['date']; ?>"
            required
        >

        <textarea name="description" required><?php echo $row['description']; ?></textarea>

        <button type="submit" name="update" class="save-btn">
            Update
        </button>

    </form>

</div>

</body>
</html>