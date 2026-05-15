<!DOCTYPE html>
<html>
<head>
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            background-color: #f9f9f9;
        }

        .info-box {
            border: 1px solid #000; 
            padding: 20px 30px;
            max-width: 600px;
            text-align: left;
            background-color: #fff;
        }

        h1 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="info-box">
<?php
$name = "Cassious Bongot";
$age = 19;
$address = "Urdaneta, Pangasinan";
$expectation = "My expectation is to gain knowledge in server side development and improve
 my skills in creating functional web applications.";

$ageAfterFiveYears = $age + 5;

echo "<h1>Student Information</h1>";
echo "My name is <b>$name</b>.<br>";
echo "I am $age years old.<br>";
echo "I live in $address.<br>";
echo "In the next 5 years, I will be $ageAfterFiveYears years old.<br><br>";
echo $expectation;
?>
</div>

</body>
</html>