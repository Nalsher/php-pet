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

function createQuote($quoteText, $imgUrl, PDO $pdo) {
    $sql_query = "INSERT INTO posts (text,user_id,img_url) values (:text, :user_id, :url)";
    $stmt = $pdo->prepare($sql_query);
    echo $_SESSION["user_id"];
    $stmt->execute([
        "text"=>$quoteText,
        "user_id"=>$_SESSION["user_id"],
        "url"=>$imgUrl,
    ]);
}

function getQuotes(PDO $pdo) {
    $sql_query = "SELECT * FROM posts";
    $stmt = $pdo->prepare($sql_query);
    $stmt -> execute();
    $quotes = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    return $quotes;
}

if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && (isset($_POST["text"]) && isset($_POST["img_url"]))){
        createQuote($_POST["text"], $_POST["img_url"], $pdo);
        header("Location: /index.html");

    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Quote</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        html, body {
            background-image: url("BG.png");
            background-size: cover;       
            background-repeat: no-repeat; 
            background-position: center;   
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #app {
            width: 100%;
            height: 100%; /* теперь реально 100% высоты экрана */
        }
        #app > div {
            width: 100%;
            height: 100%;
            display: flex;
        }
    </style>
</head>
<body>
<div id="app">
    <div class="justify-center items-center" >
        <div class="flex justify-center items-center h-full w-full">
            <form method="POST" action="createQuotes.php" class="h-1/3 w-1/2">
                <div class="flex justfiy-center items-center h-full ">
                    <div class="block w-full">
                        <div class="flex flex-col items-center w-full h-full">
                            <input name="text" type="text" id="visitors" class="bg-white mb-[25px] border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-4 py-3.5 shadow-xs placeholder:text-body" placeholder="Quote text" required />
                            <input name="img_url" type="url" id="visitors" class="bg-white mb-[25px] border border-default-medium text-heading text-base rounded-base focus:ring-brand focus:border-brand block w-full px-4 py-3.5 shadow-xs placeholder:text-body" placeholder="Image url" required />
                        </div>
                        <div class="flex justify-center mt-[15px] w-full">
                            <input class="cursor-pointer bg-white  border rounded border-white text-heading text-base pb-[5px] pt-[5px] w-full  placeholder:text-body" type="submit" value="Create">
                        </div>
                    </div>
                </div>
            </form> 
<script>
const { createApp } = Vue;


createApp({
}).mount('#app');
</script>
</body>
</html>

