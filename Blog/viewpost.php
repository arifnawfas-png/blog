<?php
require_once 'db.php';
require_once 'templates/viewpost.php';
session_start();
$postId= $_GET['post_id'] ?? 0;

$pdo = getPDO();

$row = getpost($pdo, $postId);
if (!$row) {
 redirectAndExit('index.php?not-found=1');}

$errors= null;
if ($_POST)
    {
        $commentData = [
            'name' => trim($_POST['comment-name'] ?? ''),
            'website' => trim($_POST['comment-website'] ?? ''), 
            'text' => trim($_POST['comment-text'] ?? ''),
        ];
        if (!$errors)    
        {
            redirectAndExit('viewpost.php?post_id=' . $postId);
        }    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A blog application |
        <?php echo$htmlescape($row['title']); ?>
    </title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 0; 
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .blog_post {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px auto;
            padding: 50px;
            max-width: 600px;
            min-width: 500px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #e7e6e698;
            background-color: #555;
            padding: 10px;
            border-radius: 5px;
   
        }
        .title {
            font-size: 24px;
            color: #007BFF;
        }
        .created_at {
            font-size: 14px;
            color: #888;
        }
        .body {
            font-size: 16px;
            line-height: 1.5;
            margin-top: 10px;
        }
        .comment {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px auto;
            margin-top: 10px;
            padding: 20px;
            max-width: 600px;
            min-width: 500px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .comment-body {
            font-size: 16px;
            line-height: 1.5;
            margin-top: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px auto;
            padding: 10px;
            max-width: 600px;
            min-width: 500px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .username {
            font-weight: bold;
            color: #007BFF;
            font-size: 20px;
        }
        .username:hover {
            text-decoration: underline;
        }
        .created_at {
            font-size: 14px;
            color: #888;
        }
        
    </style>
</head>
<body>
    <?php require 'templates/title.php'; ?>
    <div class="blog_post">
        <h2 class="title">
            <?php echo$htmlescape($row['title']); ?>
        </h2>
        <div class="created_at">
            <?php echo$dateconvert($row['created_at'])   ; ?>
        </div>
        <div class="body">
            <?php echo$convertline(text: $row['body']); ?>
        </div>
    </div>
<span>
    <h3><?php echo$countcomments($pdo,$postId,false); ?> comments<p><a href="templates/comment-form.php">+ comment</a></p></h3>
</span>
       <?php foreach($countcomments($pdo,$postId, true) as $comment): ?>
             <div class="comment">
                <div class="comment-meta">
                    <span class="username"><?php echo$htmlescape($comment['nameid']) ?></span>
                    //
                    <span class="created_at"><?php echo$dateconvert($comment['created_at']) ?></span>
                </div>
                <div class="comment-body">
                    <?php echo$convertline(text: $comment['textt']) ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>
</html>