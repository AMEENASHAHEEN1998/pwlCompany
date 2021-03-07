<?php 
    session_start();
    $pageTitle = 'الانتساب';
    if(!isset($_SESSION['user'])){
        
      header('location:login.php');
    }else{
      include 'init.php'; // include init file

?>

<section class="register-form">
        <div class="container">
            <h3>طلب انتساب</h3>
            <div class="row">
              <div class="col-lg-6 shad">
              <?php
                $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
                if($do == 'Manage'){
              $userid = isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']): 0 ;
                $stmt = $con->prepare("SELECT * from pwlcompany.users WHERE UserId = ? ");
                $stmt->execute(array($userid));
                $rows = $stmt->fetchAll();
                foreach($rows as $row){?>
                <form action='<?php echo "affiliation.php?id=$userid&do=insert" ?>' method ="POST" enctype = 'multipart/form-data' >
                    <input type = 'hidden' value = '<?php echo $userid ?>' name = 'userid'>
                    
                    <label for="nam" class="la">اسم المستخدم</label>
                    
                    <input id="nam" type="text" value = "<?php echo $row['UserName']; }?>" class="form-control in" id="exampleInputEmail1" placeholder="ادخل اسم المستخدم">      
                    
                    <label for="em" class="la">البريد الالكتروني</label>
                    <input id="em" type="email" name="email" class="form-control in" id="exampleInputEmail1" placeholder="ادخل البريد الالكتروني">      
                    
                    <label for="ph" class="la">رقم الهاتف</label>
                    <input id="ph" type="phone" name= "phone" class="form-control in" id="exampleInputEmail1" placeholder="ادخل رقم الهاتف">      

                    <label for="scope" class="la">التخصص</label>
                    <input id="scope" type="text" name="college"  class="form-control in" id="exampleInputEmail1" placeholder="ادخل تخصصك">      

                    <label for="job-title" class="la">المسمى الوظيفي</label>
                    <input id="job-title" type="text" name="job" class="form-control in" id="exampleInputEmail1" placeholder="ادخل رقم الهاتف">      

                    <div class="form-inline">
                        <label for="exampleFormControlFile1" class="la"> السيرة الذاتية</label>
                        <input type="file" name="cv" class="form-control-file" id="exampleFormControlFile1" style="display:inline;">
                    </div>
                      
                    <div class="form-inline">
                        <label for="exampleFormControlFile1" class="la">صورة شخصية </label>
                        <input type="file" name="photo" class="form-control-file" id="exampleFormControlFile1" style="display:inline;">
                      </div>
                    
                    <input type="submit" class="btn btn-primary" value="تسجيل">
                </form>
                </div>
      
              <div class="col-lg-6">
                <img class="img-responsive img-rounded " style="max-width:100%;height:700px;margin-right: 25px; "src="images/online-registration-concept-with-flat-design_23-2147978341.jpg" alt="">
              </div>


<?php 
      }elseif($do == 'insert'){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // نفس الاسم الي في التاغ زي اتربيوت النيم
          $userid  =$_POST['userid'];
          $email          = $_POST['email'];
          $phone           = $_POST['phone'];
          $college           = $_POST['college'];
          $job           = $_POST['job'];
          
          
          // upload variable   انبعت الي صورة فيها متغيرات على شكل مصفوفة 
          //$photo = $_FILES['photo'];
    
          $photoName = $_FILES['photo']['name'];
          $photoSize = $_FILES['photo']['size'];
          $photoTmp = $_FILES['photo']['tmp_name'];
          $photoType = $_FILES['photo']['type'];
    
          // list of upload file extention allow
          $photoAllowExtention = array("jpeg","jpg","png","gif");
    
          // get photo extention
          $tmp1 =explode(".",$photoName);
          $photoExtention = strtolower(end($tmp1));
          
          $cvName = $_FILES['cv']['name'];
          $cvSize = $_FILES['cv']['size'];
          $cvTmp = $_FILES['cv']['tmp_name'];
          $cvType = $_FILES['cv']['type'];
    
          // list of upload file extention allow
          $cvAllowExtention = array("txt","pdf","word" ,"png");
    
          // get photo extention
          $tmp2 = explode(".",$cvName);
          $cvExtention = strtolower(end($tmp2));
    
          
          // validation for input
    
          $formErrors = array();
          if(strlen($college) < 4){
              $formErrors[] = "<div class = 'alert alert-danger'> User Name can not be <strong> less than 4 </strong> </div>";
          }
          if(strlen($college) > 100){
              $formErrors[] = "<div class = 'alert alert-danger'> User Name can not be <strong>more than 20</strong> </div>";
          }
          if(empty($college)){
              $formErrors[] = "<div class = 'alert alert-danger'> User Name is <strong>empty</strong> </div>";
          }
          if( empty($job)){
            $formErrors[] = "  يجب ادخال المسمى الوظيفي  ";
            
          }
          if( empty($email)){
            $formErrors[] = "  يجب ادخال البريد الالكتروني  ";
            
          }
          if( empty($phone)){
            $formErrors[] = "  يجب ادخال رقم الجوال  ";
            
          }
          if(! empty($photoName)&& ! in_array($photoExtention,$photoAllowExtention)){
              $formErrors[] = " امتداد هذه الصورة غير متاح ";
              
          }
          if( empty($photoName)){
              $formErrors[] = "  يجب ادخال صورة  ";
              
          }
          if( $cvSize > 4194304){
              $formErrors[] = "  4MBلا يجب أن تكوم الصورة اكبر من   ";
              
          }
          if(! empty($cvName)&& ! in_array($cvExtention,$cvAllowExtention)){
            $formErrors[] = " امتداد هذه الصورة غير متاح ";
            
        }
        if( empty($cvName)){
            $formErrors[] = "  يجب ادخال صورة  ";
            
        }
        if( $cvSize > 4194304){
            $formErrors[] = "  4MBلا يجب أن تكوم الصورة اكبر من   ";
            
        }
    
    
          foreach($formErrors as $error){
              $Msg= $error ;
              redirectPage($Msg,'back' , 5);
          }
    
          // check if is there no error in update process
          if(empty($formErrors)){
              $photo = rand(0 , 1000000) . '_' . $photoName;
              move_uploaded_file($photoTmp,'uploads\photo\\' . $photo);
    
              $cv = rand(0 , 1000000) . '_' . $cvName;
              move_uploaded_file($cvTmp,'uploads\photo\\' . $cv);
              //echo $username . $userid . $email . $fullname;
              
              $stmt = $con->prepare("INSERT INTO pwlcompany.requests(userId, email , phoneNumber , img  , specialization , Job  , CV  ,accept )
              value (:zuserid,:zemail,:zphone, :zimg , :zspical ,:zjob , :zcv , 0 )");
              $stmt->execute(array(
                  'zuserid' => $userid , 
                  'zemail'       => $email,
                  'zphone'       => $phone,
                  'zimg'        => $photo, 
                  'zspical'        => $college,   
                  'zjob'        => $job,   
                  'zcv'        => $cv,   
    
              ));
              $Msg = '<div class= "alert alert-success">'. $stmt->rowCount() . "تم اضافة الطلب بنجاح".'</div>';
              echo $Msg;
              
              
    
              
             
          
          }
          
      }else {
          $Msg = "<div class = 'alert alert-danger'>عذرا لا تستطيع الدخول هنا مباشرة</div>";
          redirectPage($Msg);
          
      }}
      echo "</div>";
    }
    include $tpl . 'Footer.php';
?>