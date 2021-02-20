<?php

$dsn    = "mysql:host=localhost;dbname = "; // data soures name ,host name ,database name
$user   = 'root'; 
$pass   ='';
$option = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // عشان يخلي الترميز utf8 يقبل اللغة العربية 

);

try{
    $con = new PDO($dsn,$user,$pass,$option); // أنشأت اتصال في الداتابيز 
    $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); //   ERRMODE_EXCEPTIONوقيمتو ATTR_ERRMODE حطيت اتربيوت 
    //echo "you are connected welcomE to Database <br>";
}
catch(PDOException $e){// لو ظهر خطأ في الاتصال يظهرو 
    echo "Failed to connect to Database" . $e->getMessage();
}