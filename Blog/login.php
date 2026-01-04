<?php 
require_once 'db.php';
if (version_compare(PHP_VERSION,'7.2.0','<')) {
    die('PHP 7.2.0 or higher is required.');
}

session_start();
if ($isloggedin())
{
    redirectAndExit('index.php');
}
$username='';
if ($_POST) {
    session_start();
    $pdo = getPDO();

    $username = trim($_POST['username'] ?? '');
    $ok = $trylogin($pdo, $username, $_POST['password'] ?? '');
    if ($ok) {
        login($username);
        redirectAndExit('index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .header {
            margin-bottom: 20px;

        }
        .form-login {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
    <?php require 'templates/title.php'; ?>
    </div>
    <?php if ($username): ?>
<div style="color:red; border:1px solid; padding:10px; margin-bottom:10px;">
    Login failed for user <?php echo$htmlescape($username); ?>
</div>
    <?php endif; ?>

        <div class="form-login">
            <p>Login here:</p>
            <form method="post" action="login.php">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo$htmlescape($username); ?>" required><br><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="submit" value="Login">
    </div>
</body>
</html>