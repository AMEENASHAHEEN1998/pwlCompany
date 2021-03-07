<?php
    session_start();
    $noNavbar ='';
    $pageTitle = 'تسجيل جديد';
    if(isset($_SESSION['user'])){
        header('location:index.php');
    }
    include 'init.php'; // include init file
    

    //check if user come from http request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $photoName = $_FILES['photo']['name'];
        $photoSize = $_FILES['photo']['size'];
        $photoTmp = $_FILES['photo']['tmp_name'];
        $photoType = $_FILES['photo']['type'];

        // list of upload file extention allow
        $photoAllowExtention = array("jpeg","jpg","png","gif");

        // get photo extention
        $tmp = explode(".",$photoName);
        $photoExtention = strtolower(end($tmp));

        $username = $_POST['username'];
        $password = $_POST['password'];
        $pass_again = $_POST['pass_again'];
        $hashedPass = sha1($password);

        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // validation for input

        $formErrors = array();
        if(strlen($username) < 4){
            $formErrors[] = " اسم المستخدم لا يجب أن يكون أقل من 4 حروف ";
        }
        if(strlen($username) > 20){
            $formErrors[] = " اسم المستخدم لا يتجاوز 20 حرف ";
        }
        if(empty($username)){
            $formErrors[] = "اسم المستخدم لا يجب ان يكون فارغ ";
        }
        if(empty($password)){
            $formErrors[] = " كلمة المرور فارغة  ";
        }
        if(empty($email)){
            $formErrors[] = " البريد الالكتروني فارغ ";
        }
        if(empty($phone)){
            $formErrors[] = " رقم الجوال فارغ ";
        }
        if(! empty($photoName)&& ! in_array($photoExtention,$photoAllowExtention)){
            $formErrors[] = " امتداد هذه الصورة غير متاح ";
            
        }
        if( empty($photoName)){
            $formErrors[] = " الصورة مطلوبة ";
            
        }
        if( $photoSize > 4194304){
            $formErrors[] = "  4MBلا يجب أن يكون حجم الصورة أكبر من  ";
            
        }
        if(isset($_POST['password']) && isset($_POST['pass_again'])){
            if(empty($_POST['password'])){
                $formErrors[] = 'Sorry Password Can Not Be Empty';
            }

            $pass = sha1($_POST['password']);
            $pass_again = sha1($_POST['pass_again']);

            if($pass !== $pass_again){
                $formErrors[] = 'Sorry Password Not Match';
            }
        }

        foreach($formErrors as $error){
            echo "<div class = 'alert alert-danger'>" .$error."</div>" ;
        }

        // check if is there no error in update process
        if(empty($formErrors)){

            $photo = rand(0 , 1000000) . '_' . $photoName;
            move_uploaded_file($photoTmp,'\uploads\photo\\' . $photo);

            $check = checkItem("UserName","pwlcompany.users",$username);
            if($check == 1){
                $Msg = "<div class = 'alert alert-danger'>عذرا خذا المستخدم موجود مسبقا</div>";
                redirectPage($Msg,'back' , 5);
            }else{
                // insert into db
                $stmt = $con->prepare("INSERT INTO pwlcompany.users(UserName ,Password , Email , PhoneNumber , Status  , img)
                value (:zuser,:zpass,:zemail ,:znumber ,0  , :zphoto)");
                $stmt->execute(array(
                    'zuser'     => $username,
                    'zpass'     => $hashedPass,
                    'zemail'    => $email,
                    'znumber'     => $phone,
                    'zphoto'    => $photo
                ));
                $Msg = '<div class= "alert alert-success">'.$stmt->rowCount()  . "تم الاضافة".'</div>';
                
            // if count > 0 this mean that connect to database correct
                if($stmt->rowCount() > 0){
                    $_SESSION['user'] = $username; // register session name 
                    $_SESSION['uid'] = $get['UserId'];// register userid in session
                    header('location:index.php'); // transfer to dashpored page
                    exit();
                }
            }
        }


    }
    
    
    
?>
<!-- register page html code -->

<div class="register" style="max-width: 380px; margin: auto; ">
    <h2 class='text-center ' style="color: #c0c0c0;">تسجيل جديد</h2>
    <form class='signup' action="<?php echo $_SERVER['PHP_SELF'] ?>" method ="POST" enctype = 'multipart/form-data' >
        <label for="username" style="margin: 10px;"> اسم المستخدم</label>
        <input class='form-control' id="username" type="text" name='username' autocomplete ='OFF' pattern = '.{4,}' title='User Name Must Be more than 4 chars' placeholder='أدخل اسم المستخدم' required>
        <label for="email" style="margin: 10px;"> البريد الالكتروني</label>
        <input class='form-control' id="email" type="email" name='email' autocomplete ='off' minlenght = '5' placeholder='أدخل ايميل صحيح' required>
        <label for="phone" style="margin: 10px;">رقم الجوال</label>
        <input class='form-control' id="phone" type="number" name='phone' autocomplete ='off' minlenght = '10' placeholder='أدخل رقم الجوال' required>
        <label for="img" style="margin: 10px;"> صورة شخصية</label>
        <input class='form-control' id ="img" type="file" name='photo'   required>
        <label for="pass" style="margin: 10px;"> كلمة المرور</label>
        <input class='form-control' id="pass" type="password" name='password' autocomplete ='new-password' minlenght = '5' placeholder='أدخل كلمة مرور قوية' required>
        <label for="pass_again" style="margin: 10px;"> أعد ادخال كلمة المرور </label>
        <input class='form-control' id="pass_again" type="password" name='password-again' autocomplete ='new-password' placeholder='أعد ادخال كلمة المرور' required>
        <input class='btn btn-success btn-block' style="margin-top: 10px;"  type="submit" name ='signup' value='تسجيل'>

    </form>
</div>
