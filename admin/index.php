<?php
    session_start();
    $noNavbar ='';
    $pageTitle = 'Login';
    if(isset($_SESSION['UserName'])){
        header('location:dashpored.php');
    }
    include 'init.php'; // include init file
    

    //check if user come from http request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = $_POST['password'];
        //$hashedPass = sha1($password);
        

        // check if user exist in database
        $stmt = $con->prepare("SELECT UserId, UserName,Password FROM pwlcompany.users WHERE UserName = ? AND Password = ? AND Status = 1  ");// AND GroupId = 1  هاد لو بدي بس الأعضاء الرئيسين هم الي يقدرو يفوتو
        $stmt->execute(array($username,$password));
        $row = $stmt->fetch();
        
        
        $count = $stmt->rowCount();
        
        // if count > 0 this mean that connect to database correct
        if($count > 0){
            $_SESSION['UserName'] = $username; // register session name
            $_SESSION['ID']   = $row['UserId']; // register session id
            header('location:dashpored.php'); // transfer to dashpored page
            exit();
        }else {
            echo "error User Name and Password not correct";
        }

    }
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method ="POST">
    <h4 class="text-center">User Login</h4>
    <input class="form-control" type = "text" name ="user" placeholder = "User Name" autocomplate="off"/>
    <input class="form-control" type = "password" name ="password" placeholder = "User Password" autocomplate="new-password"/>
    <input class="btn btn-primary btn-block" type = "submit" value = "Login"/>
    
</form>

<?php
    include $tpl . 'Footer.php';
    ?>