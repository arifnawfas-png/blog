<?php 
require_once 'db.php';
require_once 'templates/edit-post.php';
require_once 'templates/viewpost.php';

session_start();
if (!$isloggedin())
{
    redirectAndExit('index.php');
}

    $title = $body = '';
    $pdo = getPDO();


    $postid = null;
    if (isset($_GET['post_id'])) 
    {
        $post = getpost($pdo, $_GET['post_id']);
        if ($post)
        {
            $postid = $_GET['post_id'];
            $title = $post['title'];
            $body = $post['body'];
        }
    }
    $errors=array();
    if ($_POST) 
    {
        $title = $_POST['post-title'];
        if (!$title)
        {
            $errors[] = 'The post must have a title';
        }
        $body = $_POST['post-body'];
        if (!$body) 
        {
            $errors[] = 'The post must have a body';
        }

        if (!$errors)
        {
            $pdo = getPDO();
       
            if ($postid) 
            {
                $editpost($pdo, $title, $body, $postid);
            }
            else 
            {
                $userid = $getauthuserid($pdo);
                $postid = $addpost($pdo, $title, $body, $userid);

                if ($postid === false)
                {
                    $errors[] = 'Post operation failed';
                }
            }
            
        }

        if ($postid === false)
        {
            $errors[] = 'Post operation failed';
        }
    }

    if ($_POST && !$errors) 
    {
        $pdo = getPDO();
        if ($postid) {
            $editpost($pdo,$title,$body,$postid);
        }else {
            $userid = $getauthuserid($pdo);
            $postid = $addpost($pdo, $title, $body, $userid);
        }
        $_SESSION['success_message'] = 'Post saved successfully!';
        redirectAndExit('edit-post.php?post_id=' . $postid);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A blog application | New post</title>
    <?php require 'templates/head.php'; ?>
    <style>
        .post-form{
            margin:10px;
        }
        .post-title {
            margin:10px
        }
        .success-box {
            margin: 10px;
            font-weight: bold;
            padding: 7px;
            background-color: #3ad335ff;
            color: white;
        }
        
    </style>
</head>
<body> 
    <?php require 'templates/top-menu.php' ?>

    <?php if (isset($_GET['post_id'])): ?>
        <h1>Edit post</h1>
    <?php else: ?>
        <h1>New Post</h1>
    <?php endif ?>
    <?php require 'templates/title.php';?>
    <?php if (isset($_SESSION['success_message'])):?>
        <div class="success-box">
            <?php 
            echo$_SESSION['success_message'];
            unset($_SESSION['success_message']);
            ?>
        </div>
        <?php endif; ?>
    <?php if ($errors): ?>
        <div class="error-box">
            <ul>
                <?php foreach ($errors as $error):?>
                    <li><?php echo$error ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form method="post" class="post-form">
            <div>
                <label for="post-title">Title:</label>
                <input id="post-title" name="post-title" type="text"
                value="<?php echo$htmlescape($title)?>"/>
            </div>
            <div>
                <label for="post-body">Body:</label>
                <textarea id="post-body" name="post-body" rows="12" cols="70"
                ><?php echo$htmlescape($body)?></textarea>
            </div>
             <input type="submit" value="Save post"><br>
             <a href="index.php">Cancel</a>
    </form>

</body>
</html>