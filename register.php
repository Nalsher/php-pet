<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <p>text</p>
    <body>
        <?php
        $login = $_POST["login"];
        $password = $_POST["password"];
        
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
        
        $sql_query = "INSERT INTO users (username, password) values (:name, :password)";
        
        $stmt = $pdo->prepare($sql_query);
        
        $stmt->execute([
            "name" => $login,
            "password" => $password
        ]);
                
        header('Location: /index.html')

        ?>                  
    </body>
</html>
