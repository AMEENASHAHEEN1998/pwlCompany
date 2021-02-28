<?php
/*
** member page
** can add | delete | edit | update | manage
*/
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='المستخدمين';
        include 'init.php';
        $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
        if($do == "Manage"){

            
            if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
                
            }
            
            // select all user in db without admin
            $stmt = $con->prepare("SELECT * from pwlcompany.users where GroupId != 1  ORDER BY pwlcompany.users.UserId DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if(! empty($rows)){

            
            ?>
            <h2 class=" text-center"  >ادارة المبرمجين</h2>
            <div class ='container'>
                <div class = 'table-responsive'>
                    <table class = 'main-table manage-members text-center table table-bordered'>
                        <tr>
                            <td>#الرقم</td>
                            <td>صورة</td>
                            <td>اسم المبرمج</td>
                            <td>الايميل</td>
                            <td>رقم الجوال</td>
                            <td>التحكم</td>
                            
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['UserId'] . "</td>";
                                    echo "<td>";
                                        if(empty($row['img'])){
                                            echo '<img class ="img-responsive"src= "../layout/image/personal.png" alt =""/>';
                                        }else{
                                            echo "<img src='uploads/photo/" . $row['img'] . "'alt=''>";
                                        }
                                    
                                    echo "</td>";
                                    echo "<td>" . $row['UserName'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['PhoneNumber'] . "</td>";
                                    echo "<td>
                                                <a href='users.php?do=Edit&userid=". $row['UserId'] ."  '  class='btn btn-success btnPadd'><i class='far fa-edit'></i> Edit</a>
                                                <a href='users.php?do=Delete&userid=". $row['UserId'] ." ' class='btn btn-danger confirm btnPadd'><i class='fa fa-close'></i> Delete</a>";
                                                if($row['Status'] == 0){
                                                echo "<a href='users.php?do=Active&userid=". $row['UserId'] ." ' class='btn btn-info btnPadd active'><i class='fa fa-check'></i> Active</a>";
                                                }
                                                echo"</td>";
                                    
                                echo "</tr>";

                            }
                        ?>
                        
                    </table>
                </div>
            <a href = "users.php?do=Add" class = "btn btn-primary"><i class = "fa fa-plus"></i> اضافة مبرمج جديد</a>
            </div>
            
            <?php  
            }else {
                echo '<div class = "container">';
                    echo '<div class="nice-message">لا يوحد مبرمجين </div>';
                    echo '<a href = "users.php?do=Add" class = "btn btn-primary"><i class = "fa fa-plus"></i> New Member</a>';
                echo '</div>';
            }
        }elseif($do == 'Add'){?>

            <h2 class=" text-center"  >اضافة مبرمج</h2>
            <div class ='container'>
                <form class='form-horizontal ' action = '?do=Insert' method = 'POST' enctype = 'multipart/form-data'>
                <!-- Start username filed-->
                    <div class ="row form-group form-group-lg">
                        <label class="control-lable col-sm-2 " >اسم المستخدم</label>
                        <div class = "col-sm-10 col-md-5">
                            <input type="text" name="username" class="form-control"  required = "required" placeholder = "ادخل اسم المستخدم" autocomplete = 'off'>
                        </div>
                    </div>
                <!-- End username filed-->

                <!-- Start Password filed-->
                    <div class ='row form-group'>
                        <label class='control-lable col-sm-2' >كلمة المرور</label>
                        <div class = 'col-sm-10 col-md-5'>
                            <input type="password" name='password' class='password form-control' autocomplete = 'new-password' required = "required" placeholder = "ادخل كلمة مرور قوية">
                            <i class = "show-pass fa fa-eye fa-2x"></i>
                            

                        </div>
                    </div>
                <!-- End Password filed-->
                <!-- Start email filed-->
                    <div class ='row form-group'>
                        <label class='control-lable col-sm-2' >البريد الالكتروني</label>
                        <div class = 'col-sm-10 col-md-5'>
                            <input type="email" name='email'  class='form-control' required = "required" placeholder = "ادخل بريد الكتروني جيد">
                        </div>
                    </div>
                <!-- End email filed-->
                <!-- Start email filed-->
                <div class ='row form-group'>
                        <label class='control-lable col-sm-2' >رقم الجوال</label>
                        <div class = 'col-sm-10 col-md-5'>
                            <input type="number" name='number'  class='form-control' required = "required" placeholder = "ادخل رقم الجوال">
                        </div>
                    </div>
                <!-- End email filed-->
                
                <!-- Start photo filed-->
                <div class ='row form-group '>
                        <label class=' col-sm-2 control-lable' >صورة شخصية</label>
                        <div class = 'col-sm-10 col-md-5'>
                            <input type="file" name='photo'  class='form-control' required = "required" >
                        </div>
                    </div>
                <!-- End photo filed-->
                <!-- Start save filed-->
                    <div class ='row form-group text-center'>
                        <div class = ' col-sm-10'>
                            <input type="submit" value='احفظ' class='btn btn-primary '>
                        </div>
                    </div>
                <!-- End save filed-->

                </form>
            </div> 
        <?php
                
            
        }elseif($do == 'Insert'){
            
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h2 class='text-center'>Insert Member</h2> ";
                echo "<div class = 'container' >" ;
                // upload variable   انبعت الي صورة فيها متغيرات على شكل مصفوفة 
                //$photo = $_FILES['photo'];

                $photoName = $_FILES['photo']['name'];
                $photoSize = $_FILES['photo']['size'];
                $photoTmp = $_FILES['photo']['tmp_name'];
                $photoType = $_FILES['photo']['type'];

                // list of upload file extention allow
                $photoAllowExtention = array("jpeg","jpg","png","gif");

                // get photo extention
                $tmp = explode(".",$photoName);
                $photoExtention = strtolower(end($tmp));
                

                // نفس الاسم الي في التاغ زي اتربيوت النيم
                
                $username = $_POST['username'];
                $email = $_POST['email'];
                $number =$_POST['number'];
                $pass = $_POST['password'];
                $hashPass = sha1($_POST['password']);

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
                if(empty($pass)){
                    $formErrors[] = " كلمة المرور فارغة  ";
                }
                if(empty($email)){
                    $formErrors[] = " البريد الالكتروني فارغ ";
                }
                if(empty($number)){
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

                foreach($formErrors as $error){
                    echo "<div class = 'alert alert-danger'>" .$error."</div>" ;
                }

                // check if is there no error in update process
                if(empty($formErrors)){

                    $photo = rand(0 , 1000000) . '_' . $photoName;
                    move_uploaded_file($photoTmp,'uploads\photo\\' . $photo);

                    $check = checkItem("UserName","pwlcompany.users",$username);
                    if($check == 1){
                        $Msg = "<div class = 'alert alert-danger'>عذرا خذا المستخدم موجود مسبقا</div>";
                        redirectPage($Msg,'back' , 5);
                    }else{
                        // insert into db
                        $stmt = $con->prepare("INSERT INTO pwlcompany.users(UserName ,Password , Email , PhoneNumber , Status  , img)
                        value (:zuser,:zpass,:zemail ,:znumber ,1  , :zphoto)");
                        $stmt->execute(array(
                            'zuser'     => $username,
                            'zpass'     => $hashPass,
                            'zemail'    => $email,
                            'znumber'     => $number,
                            'zphoto'    => $photo
                        ));
                        $Msg = '<div class= "alert alert-success">'. $stmt->rowCount() . "تم الاضافة".'</div>';
                        redirectPage($Msg,'back' , 5);
                    
                    }
                }
                
            }else {
                echo '<div class = "container">';
                    $Msg = "<div class ='alert alert-danger' >عذرا لا تقدر على الوصول هنا مباشرة</div>";
                    redirectPage($Msg);
                echo '</div>';
            }
            echo "</div>";
            
        }
        elseif($do == 'Edit'){
            // check if GET request user id is number and get userid value
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
           // select all data depends in this id 
            $stmt = $con->prepare("SELECT * FROM pwlcompany.users WHERE UserId = ?  LIMIT 1");
            //ececute query
            $stmt->execute(array($userid));
            // featch data from db
            $row = $stmt->fetch(); 
            // the row count 
            $count = $stmt->rowCount();
            // if there is such id show the form 
            if($count > 0){?>

                <h2 class=" text-center"  >تحديث العضو </h2>
                <div class ='container'>
                    <form class='form-horizontal ' action = '?do=Update' method = 'POST' enctype = 'multipart/form-data'>
                        <input type = 'hidden' value = '<?php echo $userid ?>' name = 'userid'>
                    <!-- Start username filed-->
                        <div class ="row form-group form-group-lg">
                            <label class="control-lable col-sm-2 " >اسم المستخدم</label>
                            <div class = "col-sm-10 col-md-5">
                                <input type="text" name="username" class="form-control" value = "<?php echo $row['UserName'] ?>" required = "required" autocomplete = 'off'>
                            </div>
                        </div>
                    <!-- End username filed-->

                    <!-- Start Password filed-->
                        <div class ='row form-group'>
                            <label class='control-lable col-sm-2' >كلمة المرور</label>
                            <div class = 'col-sm-10 col-md-5'>
                                <input type="hidden" name='oldPassword' value = "<?php echo $row['Password'] ?>">
                                <input type="password" name='newPassword' class='form-control' autocomplete = 'new-password' placeholder = "Leave Blank if you do not need change">
                            </div>
                        </div>
                    <!-- End Password filed-->
                    <!-- Start email filed-->
                        
                        <div class ='row form-group'>
                            <label class='control-lable col-sm-2' >البريد الالكتروني</label>
                            <div class = 'col-sm-10 col-md-5'>
                                <input type="email" name='email' value = "<?php echo $row['Email'] ?>" class='form-control' required = "required">
                            </div>
                        </div>
                    <!-- End email filed-->
                    <!-- Start phone number filed-->
                        
                    <div class ='row form-group'>
                            <label class='control-lable col-sm-2' >رقم الجوال </label>
                            <div class = 'col-sm-10 col-md-5'>
                                <input type="number" name='number' value = "<?php echo $row['PhoneNumber'] ?>" class='form-control' required = "required">
                            </div>
                        </div>
                    <!-- End phone number filed-->
                    
                    <!-- Start photo filed-->
                        <div class ='row form-group '>
                            <label class=' col-sm-2 control-lable' >صورة شخصية </label>
                            <div class = 'col-sm-10 col-md-5'>
                                            
                                <input type="file" name='photo' value = "<?php echo $row['img'] ;  ?>"  class='form-control' required = "required" >
                            </div>
                        </div>
                    <!-- End photo filed-->
                    <!-- Start save filed-->
                        <div class ='row form-group text-center'>
                            <div class = ' col-sm-10'>
                                <input type="submit" value='احفظ' class='btn btn-primary '>
                            </div>
                        </div>
                    <!-- End save filed-->

                    </form>
                </div>
            <?php
            // else show if ther is no such id in db
            }else {
                echo '<div class = "container">';
                    $Msg = "<div class ='alert alert-danger' >لا يوجد مستخدم بهذا الرقم " . $userid .'</div>';
                    redirectPage($Msg);
                echo '</div>';
            }
        
        }elseif($do == 'Update'){
            echo "<h2 class='text-center'>تحديث العضو </h2> ";
            echo "<div class = 'container' >" ;
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                // upload variable   انبعت الي صورة فيها متغيرات على شكل مصفوفة 
                //$photo = $_FILES['photo'];

                $photoName = $_FILES['photo']['name'];
                $photoSize = $_FILES['photo']['size'];
                $photoTmp = $_FILES['photo']['tmp_name'];
                $photoType = $_FILES['photo']['type'];

                // list of upload file extention allow
                $photoAllowExtention = array("jpeg","jpg","png","gif");

                // get photo extention
                $tmp = explode(".",$photoName);
                $photoExtention = strtolower(end($tmp));
                
                // نفس الاسم الي في التاغ زي اتربيوت النيم
                $username = $_POST['username'];
                $userid = $_POST['userid'];
                $email = $_POST['email'];
                $number = $_POST['number'];

                // password trick 

                $pass ='';
                if (empty($_POST['newPassword'])){
                    $pass = $_POST['oldPassword'];
                }else{
                    $pass = sha1($_POST['newPassword']);
                }
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
                if(empty($pass)){
                    $formErrors[] = " كلمة المرور فارغة  ";
                }
                if(empty($email)){
                    $formErrors[] = " البريد الالكتروني فارغ ";
                }
                if(empty($number)){
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

                
                
                foreach($formErrors as $error){
                    $Msg= $error ;
                    /*redirectPage($Msg,'back' , 5);*/
                }

                // check if is there no error in update process
                if(empty($formErrors)){
                    $photo = rand(0 , 1000000) . '_' . $photoName;
                    move_uploaded_file($photoTmp,'uploads\photo\\' . $photo);
                    
                    $stmt2 = $con->prepare("SELECT * FROM pwlcompany.users WHERE UserName = ? AND UserId != ?");
                    $stmt2 ->execute(array($username , $userid));
                    $count = $stmt2->rowCount();
                    if($count == 1){
                        $Msg = "<div class = 'alert alert-danger'>عذرا هذا الاسم موجود مسبقا </div>";
                        redirectPage($Msg,'back',3);
                    }else {
                        //echo $username . $userid . $email . $fullname;

                        $stmt = $con->prepare("UPDATE pwlcompany.users SET UserName = ? , Email = ? , PhoneNumber = ? و img = ? ,Password = ?, Status = 1 ,  GroupId = 0 WHERE UserId = ?");
                        $stmt->execute(array($username ,$email ,$number , $photo ,$pass ,$userid ));
                        

                        $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم تحديث البيانات".'</div>';
                        redirectPage($Msg,'back' , 5);
                        
                    }
                    
                
                }
                
            }else {
                $Msg = "<div class = 'alert alert-danger'>لا يمكن الوصول الي هذا العنوان مباشرة</div>";
                redirectPage($Msg);
                
            }
            echo "</div>";
            
        }
        elseif($do == 'Delete'){ // delete page member

            echo "<h2 class='text-center'>حذف عضو</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                // select all data depends in this id 
                /*
                use itemfunction insted of next line
                    $stmt = $con->prepare("SELECT * FROM shops.users WHERE UserId = ?  LIMIT 1");
                    //ececute query
                    $stmt->execute(array($userid));
                    // the row count 
                    $count = $stmt->rowCount();
                */
                $check = checkItem('UserId','pwlcompany.users',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("DELETE FROM pwlcompany.users WHERE UserId = :zuserid ");
                    $stmt->bindParam(":zuserid" , $userid);
                    $stmt->execute();
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم حذف العضو ".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "هذا العنصر غير موجود";
                        redirectPage($Msg);
                    echo '</div>';

                }
            echo'</div>';  
        }elseif($do == 'Active'){ // Active page member

            echo "<h2 class='text-center'>تفغيل المبرمجين</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                // select all data depends in this id 
                /*
                use itemfunction insted of next line
                    $stmt = $con->prepare("SELECT * FROM shops.users WHERE UserId = ?  LIMIT 1");
                    //ececute query
                    $stmt->execute(array($userid));
                    // the row count 
                    $count = $stmt->rowCount();
                */
                $check = checkItem('UserId','pwlcompany.users',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("UPDATE  pwlcompany.users SET Status = 1 where UserId = ?");
                    
                    $stmt->execute(array($userid));
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم تفعيل العضو بنجاح ".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "هذا العنصر غير موجود";
                        redirectPage($Msg);
                    echo '</div>';

                }
            echo'</div>';  
        }
        include $tpl . 'Footer.php';

    }else{
        header('location:index.php');
        exit();
    }
    ob_end_flush();
