<?php 
function getrootpath() {
 return realpath(__DIR__ );
}
function getdatabasepath() {
    return getrootpath() . '/data/blog.sqlite';
}
function getDsnstring() {
    return 'sqlite:' . getdatabasepath();

}
function getPDO() {
    static $pdo;
    if ($pdo === null) {
        try {
        $pdo = new PDO( getDsnstring() );
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            die('Could not connect to the database: ' . $e->getMessage());
        }
    }
    return $pdo;
}


$htmlescape = function ($html) {
    return htmlspecialchars($html ?? '', ENT_HTML5, 'UTF-8');
};
$dateconvert = function ($sqldate) {    
    if (!$sqldate) {
        return 'n/a';
    }
    try {
        $date = new DateTime($sqldate);
        return $date->format('jS M Y H:i:s');
    } catch (Exception $e) {
        return 'Invalid date';
    }
};
$countcomments = function (PDO $pdo,$postId, $onlyCount = true) {
    if (!$onlyCount) {
        $sql = '
            Select
            Count(*)
            From
            comment
            WHERE 
           post_id= :post_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['post_id' => $postId]);
        return (int)$stmt->fetchColumn();
    } else {
        $sql = '
            Select
            *
            From
            comment
            WHERE 
           post_id= :post_id';   
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
};

function redirectAndExit($script) {
    // Get the directory of the current script
    $dir = dirname($_SERVER['PHP_SELF']);
    if ($dir === '\\' || $dir === '/') {
        $dir = '';
    }
    
    $host = $_SERVER['HTTP_HOST'];
    // Use a relative-protocol URL or full URL
    $fullurl = 'http://' . $host . $dir . '/' . ltrim($script, '/');
    
    header('Location: ' . $fullurl);
    exit();
};
$convertline= function ($text) use ($htmlescape) 
{
    $escaped = $htmlescape($text);
    $content = str_replace("\n", "</p><p>", trim($escaped));
    
    return '<p>' . $content . '</p>';};

$trylogin = function(PDO $pdo, $username, $password) {
    $sql = '
    SELECT 
        password
    FROM
        user
    WHERE
        username = :username';

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username'=>$username]);
    
    $hash = $stmt->fetchColumn();
    $success = password_verify($password,$hash);
    return $success;
    };

function login($username) {
    session_regenerate_id();

    $_SESSION['logged_in_username']=$username;
};

$isloggedin = function() {
    return isset($_SESSION['logged_in_username']);
};

function logout() {
    unset($_SESSION['logged_in_username']);
};

function getauthuser() {
    global $isloggedin;
    return $isloggedin() ? $_SESSION['logged_in_username']: null;
};

$getauthuserid = function(PDO $pdo) use ($isloggedin) {
    if (!$isloggedin()) {
        return null;
    }

    $sql = 'SELECT 
    id
     FROM
    user
     WHERE 
    username = :username';

   $stmt = $pdo->prepare($sql);
   $stmt->execute(array(
   'username' => getauthuser()));

   return $stmt->fetchColumn();
 
};

function getsqldatefornow()
{
    return date('Y-m-d H:i:s');
}

$getallposts = function(PDO $pdo) {
    $stmt = $pdo->query(
        'SELECT id,title,created_at,body
         FROM post
         ORDER BY created_at DESC'
    );

    if ($stmt === false) {
        throw new Exception('There was a proble running the query');
    }
    return $stmt -> fetchAll(PDO::FETCH_ASSOC);
}
?>