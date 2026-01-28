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
        
try {
    $pdo = new PDO($dsn, $user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
            
} catch (Exception $ex) {
    die('Except connect' . $ex->getMessage());
}

function getQuotes(PDO $pdo) {
    $sql_query = "SELECT post.*, table_user.username FROM posts post LEFT JOIN users table_user ON table_user.id = post.user_id";
    $stmt = $pdo->prepare($sql_query);
    $stmt -> execute();
    $quotes = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    return $quotes;
}

if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $quotes = getQuotes($pdo);
        echo json_encode($quotes);
    }
}
?>