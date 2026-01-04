<?php 

$addpost = function(PDO $pdo, $title, $body, $userid) {

    $sql = "INSERT INTO
           post 
           (title,body,user_id,created_at)
           VALUES 
           (:title,:body,:user_id,:created_at)
           ";
    $stmt= $pdo->prepare($sql);
    if ($stmt === false)
    {
        throw new Exception('Could not prepare post insert query');
    }

    $result = $stmt->execute(array(
        'title'=>$title,
        'body'=>$body,
        'user_id'=>$userid,
        'created_at' => getsqldatefornow(),
    ));

    return $pdo->lastInsertId();

};

$editpost = function(PDO $pdo, $title, $body, $postid) 
{
    $sql = '
    UPDATE
     post
    SET
     title = :title,
     body = :body
    WHERE 
     id = :post_id';

    $stmt = $pdo -> prepare($sql);
    if ($stmt === false) 
    {
        throw new Exception('Could not prepare post update');
    }

    $result = $stmt->execute(array(
        'title' => $title,
        'body' => $body,
        'post_id' => $postid
    ));
    if ($result === false)
    {
        throw new Exception('Could not run post update query');
    }

    return true;

};

?>

