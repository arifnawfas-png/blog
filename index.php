<?php 
require_once __DIR__ . '/db.php';

session_start();

$pdo = getPDO();
$posts = $getallposts($pdo);

$notFound= isset($_GET['not-found']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Blog Testing PROJECT</title>
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
        .post-list {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 20px auto;
            padding: 20px;
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
            color: #555;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        .notfound {
            color: red;
            font-size: 18px;
            margin: 20px;
            background: fixed;
        }
        .post-synopsis {
     padding-bottom: 8px;
    border-bottom: 1px dotted silver;
    margin-bottom: 20px;
}
.post-synopsis h2, .post h2 {
    color: darkblue;
}
.post .date, .post-synopsis .meta {
    color: white;
    background-color: grey;
    border-radius: 7px;
    padding: 2px;
    display: inline;
    font-size: 0.95em;
}
        
    </style>
</head>
<body>
    <?php require 'templates/title.php'; 
    require_once __DIR__ . '/db.php'; 
    ?>

    <?php if ($notFound): ?>
        <div class="notfound">Error: cannot find the requested blog post</div>
    <?php endif; ?>

    <?php foreach ($posts as $post): ?>
            <div class="post-list">

        <div class="post-sypnosis">
            <a href="viewpost.php?post_id=<?php echo$post['id']; ?>">
        <h2>
            <div class="title">
                <?php echo$htmlescape($post['title']); ?>
            </div>
        </h2>
        <p>
            <div class="meta">
                <?php echo$dateconvert($post['created_at']); ?>
                <?php echo$countcomments($pdo, $post['id'], false); ?> comments
            </div>
        </p>
        <p>
            <div class="body">
                <?php echo$htmlescape($post['body']) ?>
            </div>
            </div>
        </p>

        <div class="post-controls">
        <p>
            <a href="viewpost.php?post_id=<?php echo$post['id']; ?>">Read more</a>
        </p>
        <?php if ($isloggedin()): ?>
            <a href="edit-post.php?post_id= <?php echo$post['id']?>">Edit</a>
            <?php endif; ?>
        </div>
        </div>
    </div>
    <?php endforeach; ?>
</body>
</html>