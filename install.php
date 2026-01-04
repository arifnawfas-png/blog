<?php
require_once 'db.php';
require_once 'templates/install.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_POST['install'])) {
    $pdo = getPDO();
    list($error,$rowCounts) = installBlog($pdo);

    $password='';
    if (!$error) {
        $username = 'admin';
        if (is_array($username)) { die("Error: Username is an array!"); }
        list($password, $error) = createuser($pdo, $username);
    }
    $username='';
    $_SESSION['count'] = $rowCounts;
    $_SESSION['error'] = $error;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['try-install'] = true;

    foreach ((array)$password as $pass): 
        echo"This is your admin password " . $htmlescape($pass);
    endforeach;
    

}

$attempted= false;
if (isset($_SESSION['try-install']))
    {
    $attempted = true;
    $count = $_SESSION['count'] ?? [];
    $error = $_SESSION['error'] ?? '';
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    unset($_SESSION['count']);
    unset($_SESSION['error']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['try-install']);
}
if (isset($_POST['nuke-database'])) {
   $dbFile = 'blog.sqlite';

   if (isset($_POST['confirm-check'])) {
    if (file_exists($dbFile)) {
        unlink($dbFile);
        echo"Your database has been deleted.";
    }
   } else {
    echo"Please confirm the checkbox.";
   }
}
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog installer</title>
            <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
            <style type="text/css">
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    background-color: #f4f4f4;
                }
                .box {
                    border: 1px dotted silver;
                    border-radius: 5px;
                    padding: 4px;
                }
                .error {
                    background-color: #ff6666;
                }
                .success {
                    background-color: #88ff88;
                }
                a {
            text-decoration: none;
            color: #007BFF;
               }
               .form {
                margin-bottom: 20px;
                background-color: aliceblue;
               }
               a:hover {
            text-decoration: underline;
                }
                .form {
                    margin-bottom: 20px;
                    background-color: #007BFF;
                    padding: 10px;
                    max-width: 50px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                #safety-zone {
                    display:none;
                    background:#fee;
                    border:1px solid red;
                    padding:10px;
                }
                
            </style>
        </head>
        <body>
        <?php if ($attempted): ?>
            <?php if ($error): ?>
                <div class="error box">
                    <strong>Error:</strong>
                        <?php foreach ((array)$error as $k):
                        echo$htmlescape($k). "<br>";
                        endforeach ?>
                </div>
            <?php else: ?>
                <div class="success box">
                    <strong>Success:</strong>
                    The database and demo data was created OK.
                    <?php foreach (array('post','comment') as $tableName): ?>
                        <br></r>
                    <?php if (isset($count[$tableName])): ?>
                        <?php echo $count[$tableName] ?>
                        <?php echo $tableName ?> records were created.<br />
                    <?php endif ?>
                    <?php endforeach ?> 
                    <p>The new '<?php echo$htmlescape($username)?>'</p>
                    <span><?php echo$htmlescape($password) ?></span>
                    (copy it to clipboard if you wish).                </div>
            <?php endif ?>
        <?php else: ?>
            <div class="form">
            <form method="post" name="install">
                <input name="install" type="submit" value="Install">
            </form>
            </div>
            <div class="other-form">
            <p>
                <a href="index.php">Go to blog index page</a> 
            <p>or</p>        
            <div class="safety-zone">
                <p><strong>DATABASE DELETION **PLEASE CONFIRM**</strong></p>
                <form method="post">
                    <input type="checkbox" name="confirm-check" required>
                    <label for="confirm-check">Database will be permantly deleted</label>
                    <br><br>
                    <button type="submit" name="nuke-database" value="Delete database" style="background:red; color:white; padding:10px;">DELETE</button>
                </form>
            </div>
       </p>
       </div>
        <?php endif ?>
        </body>
    </html>