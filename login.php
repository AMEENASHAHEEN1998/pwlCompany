<?php  
    ob_start(); // output buffering start
    session_start();
    include "admin/connect.php"; // db connect file 
    if(isset($_SESSION['user'])){
        header('location:index.php');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
            $username = $_POST['UserName'];
            $pass = $_POST['Password'];
            //$hashedPass = sha1($pass);
            
            

            // check if user exist in database
            $stmt = $con->prepare("SELECT UserId , UserName ,Password FROM pwlcompany.users WHERE UserName = ? AND Password = ? AND Status = 1");
            $stmt->execute(array($username,$pass)); 
            $get = $stmt->fetch(); 
            $count = $stmt->rowCount();
            
            // if count > 0 this mean that connect to database correct
            if($count > 0){
                $_SESSION['user'] = $username; // register session name 
                $_SESSION['uid'] = $get['UserId'];// register userid in session

                header('location:index.php'); // transfer to dashpored page
                exit();
            }else{
                echo 'error in user name or password';
            }
        
    }
    
?>
<html>
    <head>
        <title>تسجيل دخول</title>
    <link rel="stylesheet"href="layout/css/style.css">
    </head>
    <div class="WW">
        <span class="AA">تسجيل دخول </span>
        <form class="form" method="post">
            <div class="HH" >
                <img class="user" src="user.png">
                <input dir="rtl" type="text" name="UserName" id="username" autocomplete ='off' placeholder="اسم المستخدم " >
            </div>
            <div class="div2">
                <img class="password" src="passw.png">
                <input dir="rtl" type="password" name="Password" id="ttname" autocomplete ='new-password' placeholder="كلمة السر" >
            </div>
            <br><br>
            <input class='btn btn-primary btn-block NN' type="submit"  value='تسجيل دخول'>
            


        </form>
    </div>


