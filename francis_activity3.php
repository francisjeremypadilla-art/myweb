<!DOCTYPE html>
<html>
<head>
    <title>Login form ni dos</title>
    <style>
        body {
            background-color: #4A90E2;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
        }

        input {
            width: 90%;
            padding: 8px;
            margin: 5px 0;
        }

        button {
            background: #4A90E2;
            color: white;
            border: none;
            padding: 8px;
            width: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="box">
    <h3>Login</h3>

    <form method="POST">
        <input type="text" name="name" placeholder="Name"><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>