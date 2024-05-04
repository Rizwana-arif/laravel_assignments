<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .button-container {
            text-align: center;
            background-color: #ccbbbb; /* Set the background color for the container */
            padding: 50px; /* Add some padding for better aesthetics */
            border-radius: 10px; /* Optional: Add rounded corners */
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="button-container">
    <h1>Move on the page</h1>
    <a href="{{ route('register') }}" class="button">Register</a>
    <a href="{{ route('login') }}" class="button">Login</a>
</div>

</body>
</html>
