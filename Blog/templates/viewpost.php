<?php
function getpost(PDO $pdo, $postId) {
$stmt=$pdo->prepare('
     SELECT
        title,created_at,body
     FROM
        post
     WHERE 
        id = :id
    ');

IF ($stmt === false) {
    throw new Exception('There was a problem running this query');
}

$result = $stmt->execute(
    array('id' => $postId, )  
);
if ($result === false) {
    throw new Exception('There was a problem running this query');
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
return $row;
}

function addCommentToPost(PDO $pdo, $postId, array $commentData)
 {
    $errors = array();
    
if (empty($commentData['nameid'])) {
        $errors['nameid'] = 'Name is required.';
}
if (empty($commentData['textt'])) {
    $errors['textt'] = 'Comment text is required.';
}
if ($errors) {
    return $errors;
}

$sql = "
    INSERT INTO comment (post_id, nameid, website, textt)
    VALUES (:post_id, :nameid, :website, :textt)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':post_id' => $postId,
        ':nameid' => $commentData['nameid'],
        ':website' => $commentData['website'] ?: null,
        ':textt' => $commentData['textt'],
    ]);

    return null;
};
?>