<?php



$servername = "localhost";

$database = "cla62831_personalizer";

$username = "cla62831_usuario";

$password = "jasm91098";

$charset  = "utf8mb4";



try {



    $dsn = "mysql:host=$servername;dbname=$database;charset=$charset";

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



//    echo "Conectado OK a BD: ".$database;



    return $pdo;

} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();

}





?>