<?php
    session_start();
    
    $pageTitle =  "طلب المشروع";
    
    include 'init.php'; // include init file
    

    //check if user come from http request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $project = $_POST['project'];
        $message = $_POST['message'];
        

        

        // validation for input

        $formErrors = array();
        
        if(empty($name)){
            $formErrors[] = "اسم المستخدم لا يجب ان يكون فارغ ";
        }
        if(empty($message)){
            $formErrors[] = "  وصف المشروع فارغ    ";
        }
        if(empty($email)){
            $formErrors[] = " البريد الالكتروني فارغ ";
        }
        if(empty($phone)){
            $formErrors[] = " رقم الجوال فارغ ";
        }
        

        foreach($formErrors as $error){
            echo "<div class = 'alert alert-danger'>" .$error."</div>" ;
        }

        // check if is there no error in update process
        if(empty($formErrors)){

            
                $stmt = $con->prepare("INSERT INTO pwlcompany.project_request(name ,email  , PhoneNumber , description_project,service_id  , agree)
                value (:zuser,:zemail ,:znumber,:zdes,:zservice  ,0  )");
                $stmt->execute(array(
                    'zuser'     => $name,
                    'zemail'    => $email,
                    'znumber'     => $phone,
                    'zservice' => $project,
                    'zdes'    => $message
                ));
                $Msg = '<div class= "alert alert-success">'.$stmt->rowCount()  . "تم اضافة طلب المشروع بنجاح".'</div>';
                echo $Msg;
                
            
                
            }
        }


    
    
    
    
?>
<!--Start Ordring Project-->
  <section class="order-project">
    <div class="container">
      <h3>أطلب مشروعك</h3>
      <div class="row">
        <div class="col-lg-6">
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <label for="nam" class="la">الاسم</label>
            <input id="nam" type="text" name="name" class="form-control in" id="exampleInputEmail1" placeholder="ادخل الاسم">      
            <label for="em" class="la">البريد الالكتروني</label>
            <input id="em" type="email" name="email" class="form-control in" id="exampleInputEmail1" placeholder="ادخل البريد الالكتروني">      
            <label for="ph" class="la">رقم الهاتف</label>
            <input id="ph" type="phone" name="phone" class="form-control in" id="exampleInputEmail1" placeholder="ادخل رقم الهاتف">      
            <label for="exampleFormControlSelect1" class="la">اختر مشروعك المراد طلبه</label>
            <select class="form-control in" id="exampleFormControlSelect1" name="project">
              <?php $stmt = $con->prepare(" SELECT *  
                  from pwlcompany.services  ");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  if(! empty($rows)){
                    foreach($rows as $row){ 
                      
                      echo '<option value = " ' .$row['id'] . '">" '.$row['name'] .'" </option>';
                      

                     }
                    }?>
            </select>
            <label for="ms" class="la">وصف المشروع المراد تنفيذه</label>
            <textarea class="form-control in" id="ms" name="message" placeholder="ادخل رسالتك" rows="3"></textarea>
            
          <input type="submit" class="btn btn-primary" value="ارسال">
          </form>
          </div>

        <div class="col-lg-6">
          image
        </div>
  
      </div>
    </div>
  </section>
<!--End Ordering Project-->

<?php
                  
  include $tpl . 'Footer.php';
?> 