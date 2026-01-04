<?php 
require_once 'db.php';

session_start();

if (!$isloggedin) {
    redirectAndExit('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List post</title>
    <?php require 'templates/head.php'  ?>
    <style> 
    </style>
</head>
<body>
    <?php require 'templates/top-menu.php'?>

    <h1>Post List</h1>

    <form action="" method="post">
        <Table id="post-list">
            <tbody>
                <tr>
                    <td>Title of the first post</td>
                    <td>
                        <a href="edit-post.php?post_id=1">Edit</a>
                    </td>
                    <td>
                        <input type="submit" name="post[1]"
                        value="Delete"/>
                    </td>
                </tr>
                <tr>
                    <td>Title of the second post</td>
                    <td><a href="edit-post.php?post_id=2">Edit</a>
                </td>
                <td><input type="submit" name="post[2]" value="Delete">
            </td>
                </tr>
                 <tr>
                    <td>Title of the third post</td>
                    <td><a href="edit-post.php?post_id=3">Edit</a>
                    <td><input type="submit" name="post[3]" value="Delete">
            </td>
                </td>
                </tr>
            </tbody>
        </Table>
    </form>
</body>
</html>