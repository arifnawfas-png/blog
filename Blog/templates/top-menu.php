<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="login-form">
      <?php if ($isloggedin()): ?>Hello <?php echo$htmlescape(getauthuser()); ?>! |
            <a href="edit-post.php">New post</a><br>
            <a href="list-post.php">List post</a>
      <a href="logout.php">Log out</a>
      <?php else: ?>
    <a href="login.php">Log in</a>
      <?php endif; ?>
</div>
</body>
</html>