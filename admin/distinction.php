<?php
/*
** services page
** can add | delete | edit | update | manage
*/
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='التميز';
        include 'init.php';
        $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
        if($do == "Manage"){
            $sort = 'ASC'; //DESC OR ASC
            $sort_array = array("ASC","DESC");
            if(isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)){
                $sort = $_GET['sort'];
            }
            $stmt = $con->prepare("SELECT * from pwlcompany.distinction ORDER BY name $sort");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
            ?>
            <h2 class="text-center">المميزات</h2>
            <div class= "container categories">
                <div class="panel panel-default ">
                    <div class="panal-heading headingPanel">
                        <i class="fa fa-edit"></i> 
                        بماذا نتميز
                        <div class="option pull-left">
                            <i class="fa fa-sort" ></i> Ordering: [
                            <a class = "<?php if($_GET['sort'] == 'ASC'){echo "active" ;} ?>" href="?sort=ASC">ASC</a>
                            |
                            <a class = "<?php if($_GET['sort'] == 'DESC'){echo "active" ;} ?>" href="?sort=DESC">DESC</a> ]
                            <i class="fa fa-eye" ></i> View:[
                            <span class='active' data-view = 'Full'>Full</span> |
                            <span class ='' data-view =''>Classic</span> ]
                        </div>
                        </div>
                    <div class="panel-body">
                        <?php
                        foreach($rows as $row){
                            echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                    echo "<a href='distinction.php?do=Edit&serviesid=". $row['id'] . " 'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                    echo "<a href='distinction.php?do=Delete&serviesid=". $row['id'] . " ' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                echo"</div>";
                                echo "<h3>". $row['name'] . "</h3>";
                                echo "<div class='full-view'>";
                                    echo "<p>"; 
                                        
                                        if(empty($row['img'])){
                                            echo '<img class ="img-responsive"src= "../layout/image/personal.png" alt =""/>';
                                        }else{
                                            echo "<img src='uploads/photo/" . $row['img'] . "'alt=''>";
                                        }
                                    echo "</p>";
                                    
                                
                                
                                
                                    echo "</div>";
                                
                                echo "</div>";
                            
                            echo '<hr>';

                        }
                        
                        ?>
                    </div>
                </div>
                <a href="distinction.php?do=Add" class = " btn btn-primary"><i class = "fa fa-plus"></i> اضافة ميزة جديدة</a>
            </div>
            <?php
            }else{
                echo '<div class = "container">';
                    echo '<div class="nice-message">لا يوجد أي ميزة هنا </div>';
                    echo '<a href="distinction.php?do=Add" class = " btn btn-primary"><i class = "fa fa-plus"></i> اضافة ميزة جديدة</a>';
                echo '</div>';
            }
            
        }elseif($do == 'Add'){?>

            <h2 class=" text-center"  >اضافة ميزة</h2>
            <div class ='container'>
                <form class='form-horizontal ' action = '?do=Insert' method = 'POST' enctype = 'multipart/form-data'>
                <!-- Start Name filed-->
                    <div class ="row form-group form-group-lg">
                        <label class="control-lable col-sm-2 " >اسم الميزة</label>
                        <div class = "col-sm-10 col-md-5">
                            <input type="text" name="name" class="form-control"  required = "required" placeholder = "ادخل خدمة جديدة" autocomplete = 'off'>
                        </div>
                    </div>
                <!-- End Name filed-->

                
                <!-- Start image filed-->
                <div class ='row form-group'>
                        <label class='control-lable col-sm-2' >أضف صورة خاصة بالميزة</label>
                        <div class = 'col-sm-10 col-md-5'>
                            <input type="file" name="photo"  class='form-control' required = "required" >
                        </div>
                    </div>
                <!-- End image filed-->
                
                <!-- Start save filed-->
                    <div class ='row form-group text-center'>
                        <div class = 'col-sm-10'>
                            <input type="submit" value='احفظ' class='btn btn-primary '>
                        </div>
                    </div>
                <!-- End save filed-->

                </form>
            </div> 
        <?php 
                
            
        }elseif($do == 'Insert'){

            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                echo "<h2 class='text-center'>اضافة ميزة </h2> ";
                echo "<div class = 'container' >" ;
                // upload variable   انبعت الي صورة فيها متغيرات على شكل مصفوفة 
                //$photo = $_FILES['photo'];
                
                $photoName = $_FILES["photo"]['name'];
                $photoSize = $_FILES["photo"]['size']  ;
                $photoTmp = $_FILES["photo"]['tmp_name'] ;
                $photoType =  $_FILES["photo"]['type'];

                // list of upload file extention allow
                $photoAllowExtention = array("jpeg","jpg","png","gif");

                $tmp = explode(".",$photoName);
                // get photo extention
                $photoExtention = strtolower(end($tmp));

                // نفس الاسم الي في التاغ زي اتربيوت النيم
                
                $name           = $_POST['name'];
                
                
                
                

                // validation for input

                $formErrors = array();
                if(strlen($name) < 4){
                    $formErrors[] = "<div class = 'alert alert-danger'> لا يجب أن يكون اسم الميزة أقل من 4 حروف  </div>";
                }
                if(strlen($name) > 100){
                    $formErrors[] = "<div class = 'alert alert-danger'>لا يجب أن يكون اسم الميزة أكبر من 100 حرف   </div>";
                }
                if(empty($name)){
                    $formErrors[] = "<div class = 'alert alert-danger'> يجب ادخال اسم للميزة </div>";
                }
                
                if(! empty($photoName)&& ! in_array($photoExtention,$photoAllowExtention)){
                    $formErrors[] = " امتداد هذه الصورة غير متاح ";
                    
                }
                if( empty($photoName)){
                    $formErrors[] = "  يجب ادخال صورة  ";
                    
                }
                if( $photoSize > 4194304){
                    $formErrors[] = "  4MBلا يجب أن تكوم الصورة اكبر من   ";
                    
                }

                foreach($formErrors as $error){
                    $Msg = "<div class = 'alert alert-danger'>" .$error."</div>" ;
                    //redirectPage($Msg,'back' , 5);

                }

                // check if is there no error in update process
                if(empty($formErrors)){
                    $photo = rand(0 , 1000000) . '_' . $photoName;
                    move_uploaded_file($photoTmp,'uploads\photo\\' . $photo);

                    
                    $check = checkItem("name","pwlcompany.distinction",$name);
                    if($check == 1){
                        $Msg = "<div class = 'alert alert-danger'>عذرا هذه الخدمة موجودة مسبقا</div>";
                        redirectPage($Msg,'back' , 5);
                    }else{
                        // insert into db
                        $stmt = $con->prepare("INSERT INTO pwlcompany.distinction(name  ,img)
                        value (:zname, :zimg )");
                        $stmt->execute(array(
                            'zname'       => $name,
                            'zimg'        => $photo   
                            

                        ));
                        $Msg = '<div class= "alert alert-success">'. $stmt->rowCount() . "تم اضافة الميزة".'</div>';
                        redirectPage($Msg,'back' , 5);
                    
                    }
                }
                
            }else {
                echo '<div class = "container">';
                    $Msg = "<div class ='alert alert-danger' >عذرا لا تستطيع الوصول الي هنا مباشرة</div>";
                    redirectPage($Msg,'back' , 5);
                echo '</div>';
            }
            echo "</div>";
       
            
        }elseif($do == 'Edit'){
            // check if GET request category id is number and get userid value
            $serviesid = isset($_GET['serviesid']) && is_numeric($_GET['serviesid'])? intval($_GET['serviesid']): 0 ;
           // select all data depends in this id 
            $stmt = $con->prepare("SELECT * FROM pwlcompany.distinction WHERE id = ?");
            //ececute query
            $stmt->execute(array($serviesid));
            // featch data from db
            $row = $stmt->fetch(); 
            // the row count 
            $count = $stmt->rowCount();
            // if there is such id show the form 
            if($count > 0){?>

            <h2 class=" text-center"  >تعديل الميزة </h2>
            <div class ='container'>
                <form class='form-horizontal ' action = '?do=Update' method = 'POST' enctype = 'multipart/form-data'>
                <input type = 'hidden' value = '<?php echo $serviesid ?>' name = 'serviesid'>
                <!-- Start Name filed-->
                    <div class ="row form-group form-group-lg">
                        <label class="control-lable col-sm-2 " >اسم الميزة</label>
                        <div class = "col-sm-10 col-md-5">
                            <input type="text" name="name" class="form-control"  required = "required" placeholder = "ادخل خدمة جديدة " autocomplete = 'off' value = "<?php echo $row['name']; ?>">
                        </div>
                    </div>
                <!-- End Name filed-->

                <!-- Start photo filed-->
                <div class ='row form-group '>
                            <label class=' col-sm-2 control-lable' >صورة الميزة</label>
                            <div class = 'col-sm-10 col-md-5'>
                                            
                                <input type="file" name='photo' value = "<?php echo $row['img'] ;  ?>"  class='form-control' required = "required" >
                            </div>
                        </div>
                    <!-- End photo filed-->
                
                <!-- Start save filed-->
                    <div class ='row form-group text-center'>
                        <div class = 'col-sm-10'>
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
                    $Msg = "<div class ='alert alert-danger' >هذا العنصر غير موجود " . $serviesid .'</div>';
                    redirectPage($Msg ,'back' , 3);
                echo '</div>';
            }
            
        }elseif($do == 'Update'){
            echo "<h2 class='text-center'>حدث الميزة</h2> ";
            echo "<div class = 'container' >" ;
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){

                // نفس الاسم الي في التاغ زي اتربيوت النيم
                $serviesid          = $_POST['serviesid'];
                $name           = $_POST['name'];
                
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
                


                
                // validation for input

                $formErrors = array();
                if(strlen($name) < 4){
                    $formErrors[] = "<div class = 'alert alert-danger'> لا يجب أن يكون اسم الميزة أقل من 4 حروف  </div>";
                }
                if(strlen($name) > 100){
                    $formErrors[] = "<div class = 'alert alert-danger'>لا يجب أن يكون اسم الميزة أكبر من 100 حرف   </div>";
                }
                if(empty($name)){
                    $formErrors[] = "<div class = 'alert alert-danger'> يجب ادخال اسم للميزة </div>";
                }
                if(! empty($photoName)&& ! in_array($photoExtention,$photoAllowExtention)){
                    $formErrors[] = " امتداد هذه الصورة غير متاح ";
                    
                }
                if( empty($photoName)){
                    $formErrors[] = "  يجب ادخال صورة  ";
                    
                }
                if( $photoSize > 4194304){
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
                    //echo $username . $userid . $email . $fullname;
                    
                    $stmt = $con->prepare("UPDATE pwlcompany.distinction SET name = ? , img = ? WHERE id = ?");
                    $stmt->execute(array($name  , $photo ,$serviesid));

                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم تحديث الميزة".'</div>';
                    redirectPage($Msg,'back' , 5);
                   
                
                }
                
            }else {
                $Msg = "<div class = 'alert alert-danger'>عذرا لا تستطيع الدخول هنا مباشرة</div>";
                redirectPage($Msg);
                
            }
            echo "</div>";
            
        
        }elseif($do == 'Delete'){ // delete page distinction
            echo "<h2 class='text-center'>حدف الميزة </h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $serviesid = isset($_GET['serviesid']) && is_numeric($_GET['serviesid'])? intval($_GET['serviesid']): 0 ;
                // select all data depends in this id 
                
                $check = checkItem('id','pwlcompany.distinction',$serviesid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("DELETE FROM pwlcompany.distinction WHERE ID = :zid ");
                    $stmt->bindParam(":zid" , $serviesid);
                    $stmt->execute();
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم حذف الميزة ".'</div>';
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