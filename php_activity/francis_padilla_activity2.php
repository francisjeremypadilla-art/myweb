<!DOCTYPE html>
<html>
<head>
    <title>Technologies</title>
</head>
<body style="font-family: Times New Roman; text-align:center; margin-top:100px;">

<div style="display:inline-block; text-align:left; border:2px solid black; padding:20px; width:420px;">

<?php
$name = "Francis Jeremy Padilla";

$technologies = [
    "PHP",
    "JavaScript",
    "Python",
    "Java",
    "MySQL"
];


echo "<div style='border-bottom:1px solid black; padding-bottom:10px; margin-bottom:10px;'>";
echo "Hello! My name is <b>$name</b>.<br>";
echo "These are the technologies I want to learn:";
echo "</div>";

foreach ($technologies as $tech) {
    echo "I want to learn $tech.<br>";
}
?>

</div>

</body>
</html>