<?php
    session_start();
    $noNavbar ='';
    $pageTitle = 'Register';
    if(isset($_SESSION['user'])){
        header('location:index.php');
    }
    include 'init.php'; // include init file
    

    //check if user come from http request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$hashedPass = sha1($password);

        $email = $_POST['email'];
        
        

        // check if user exist in database
    

        $stmt = $con->prepare("INSERT INTO pwlcompany.users(UserName ,Password , Email , Status, img )
                        value (:zuser,:zpass,:zemail ,2,'0')");
                        $stmt->execute(array(
                            'zuser'     => $username,
                            'zpass'     => $password,
                            'zemail'    => $email
                        ));                         
        $count = $stmt->rowCount();
                        echo '<div class= "alert alert-success">'. $stmt->rowCount() . "Recored Insered".'</div>';
                        
        // if count > 0 this mean that connect to database correct
        if($count > 0){
            $_SESSION['user'] = $username; // register session name 
            $_SESSION['uid'] = $get['UserId'];// register userid in session
            header('location:index.php'); // transfer to dashpored page
            exit();
        }
    }
    
    
    
?>
<!-- register page html code -->
<h2 class='text-center '>SignUp</h2>
<form class='signup' action="<?php echo $_SERVER['PHP_SELF'] ?>" method ="POST" >
    <input class='form-control' type="text" name='username' autocomplete ='OFF' pattern = '.{4,}' title='User Name Must Be more than 4 chars' placeholder='Enter Your User Name' required>
    <input class='form-control' type="email" name='email' autocomplete ='off' minlenght = '5' placeholder='Enter Vailed Email' required>
    <input class='form-control' type="password" name='password' autocomplete ='new-password' minlenght = '5' placeholder='Enter Complex Password' required>
    <input class='form-control' type="password" name='password-again' autocomplete ='new-password' placeholder='Enter Password Again' required>
    <input class='btn btn-success btn-block'  type="submit" name ='signup' value='SignUp'>

</form>

<?php
    include $tpl . 'Footer.php';
    ?>