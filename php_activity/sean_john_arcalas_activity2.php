<!DOCTYPE html>
<html>
<head>
    <title>Technologies</title>
</head>
<body style="font-family: Times New Roman; text-align:center; margin-top:100px;">

<div style="display:inline-block; text-align:left; border:1px solid black; padding:20px;">

<?php
$name = "Sean John Arcalas";

$technologies = [
    "PHP",
    "JavaScript",
    "Python",
    "Java",
    "MySQL"
];

echo "Hello! My name is <b>$name</b>.<br>";
echo "These are the technologies I want to learn:<br><br>";

foreach ($technologies as $tech) {
    echo "I want to learn $tech.<br>";
}
?>

</div>

</body>
</html>