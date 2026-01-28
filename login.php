<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();

$host=$_ENV["DB_HOST"];
$db=$_ENV["DB_NAME"];
$user=$_ENV["DB_USER"];
$db_pass=$_ENV["DB_PASS"];
$charset=$_ENV["DB_CHARSET"];
        
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 
$login = $_POST["login"];
$password = $_POST["password"];


try {
    $pdo = new PDO($dsn, $user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
            
} catch (Exception $ex) {
    die('Except connect' . $ex->getMessage());
}

$sql_query = "SELECT username, id FROM users WHERE username=:username AND password=:password LIMIT 1";

$stmt = $pdo->prepare($sql_query);

$stmt->execute([
    "username" => $login,
    "password" => $password
]);

$loginUser = $stmt ->fetch(PDO::FETCH_ASSOC);

$_SESSION["username"] = $loginUser["username"];
$_SESSION["user_id"] = $loginUser["id"];

header("Location: /index.html")
?>                  
