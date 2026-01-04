<?php
function installBlog(PDO $pdo){


$root = getrootpath();
$dbfile = getdatabasepath();
$sqlfile = $root . '/data/init.sql';

$error = '';

if (file_exists($dbfile) && filesize($dbfile) > 0)
{
    $error = 'Please delete the existing database manually before installing it afresh';
}

if (!$error)
{
    if (!file_exists($sqlfile)){
        $error = 'Please make an sql file (coding file)';
    } 
    else {
        $sql = file_get_contents($sqlfile);
    }
   
    }

if (!$error) {
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec($sql);

        $stmt = $pdo->query("SELECT COUNT(*) FROM post");
    } catch (PDOException $e) {
        $error = 'Could not run SQL: ' . $e->getMessage();
    }
}
$count = array();

foreach (array('post','comment') as $tableName) {
    if (!$error) {
        $sql = "SELECT COUNT(*) AS c FROM ". $tableName;
        $stmt = $pdo->query($sql);
        if ($stmt) {
            $count[$tableName] = $stmt->fetchColumn();
        }
    } else {
        $count[$tableName] = 0;
    }
}
return array($error, $count);
}
function createuser(PDO $pdo, $username, $length=10){
    
    $alphabet = range(ord('a'), ord('z'));
    $alphabetlength = count($alphabet);
    $password = '';
    for ($i = 0; $i < $length; $i++){
        $letterCode = $alphabet[rand(0, $alphabetlength - 1)];
        $password .= chr($letterCode);
    }
    $error = '';
    $sql = "INSERT INTO user (username,password,created_at)
    VALUES (:username, :password, :created_at)";
    
    try {
    $stmt = $pdo->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $result = $stmt->execute([
            'username'   => $username,
            'password'   => $hash,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result === false) {
            $dbError = $stmt->errorInfo();
            $error = 'Database Error: ' . $dbError[2];
        }
    } catch (Exception $e) {
        $error = 'System Error: ' . $e->getMessage();
    }

    if ($error) { $password = ''; }
    return array($error, $password);
};
?>