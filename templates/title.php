<?php require 'top-menu.php'?>
<?php 
 if (isset($_GET["post_id"])){
    $postId= $_GET["post_id"];
 } 
 else {
    $postId= 0;
 }
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page <?php echo$postId ?></title>
      <style>
         body {
               font-family: Arial, sans-serif;
               margin: 20px;
               background-color: #f4f4f44b;
         }
         h1 {
               color: #333;
         }
         p {
               font-size: 16px;
               color: #555;
         }
         a {
               text-decoration: none;
               color: #007BFF;
         }
         .login-form{
            display:inline-flex;
            gap: 15px;
            justify-content: column;
         }
         </style>
 </head>
 <body>
    <a href="index.php">
    <h1>Blog title</h1></a><br>
    <p>This paragraph summarises what the blog is about.</p>

   </body>
 </html>