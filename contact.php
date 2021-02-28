<?php
    session_start();
    
    $pageTitle = 'التواصل';
    
    include 'init.php'; // include init file
    

    //check if user come from http request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $stmt = $con->prepare("INSERT INTO pwlcompany.call_us(name ,email , subject , message, call_us )
                        value (:zname,:zemail ,:zsubject , :zmessage ,0)");
                        $stmt->execute(array(
                            'zname'     => $username,
                            'zemail'     => $email,
                            'zsubject'    => $subject,
                            'zmessage' =>$message
                        ));                         
        $count = $stmt->rowCount();
                        echo '<div class= "alert alert-success">'. $stmt->rowCount() . "تم اضافة رسالتك بنجاح".'</div>';
                        
        
    }
    
    
    
?>
    

    <!-- contact section start -->

    <section class="sec-contact">
        <div class="container">
            <h1 class="text-center">اتصل بنا</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-lg-7">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">اسم المستخدم :</label>
                                    <input type="text" name="username" class="form-control" placeholder="اسم المستخدم"
                                        id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">الايميل :</label>
                                    <input type="email" name="email" class="form-control" class="form-controller"
                                        placeholder="الايميل" id="email">
                                </div>

                                <div class="form-group">
                                    <label for="subject">الموضوع :</label>
                                    <input type="text" name="subject" class="form-control" class="form-controller"
                                        placeholder="الموضوع" id="subject">
                                </div>
                                <div class="form-group">
                                    <label for="message">الرسالة :</label>
                                    <textarea name="message" class="form-control" cols="20" rows="5" id="message"
                                        placeholder="الرسالة"></textarea>
                                </div>

                                <input class="btn  text-center center-block" type="submit" value = "ارسال">

                            </div>

                        </form>
                    </div>
                    <!-- end form vontact -->

                    <div class="col-lg-4">
                        <div class="row cont">
                            <div class="cont-1">
                                <i class="fa fa-map-marker"></i>
                                <h3>فلسطين - غزة - مفترق اتحاد الكنائس</h3>
                            </div>

                            <div class="cont-1">
                                <i class="fa fa-phone"></i>
                                <h3>جوال شركة مبرمجون</h3>
                            </div>

                            <div class="cont-1">
                                <i class="fa fa-envelope"></i>
                                <h3>ايميل شركة مبرمجون</h3>
                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </div>
    </section>


    <!-- contact section end -->
   

<?php
    include $tpl . 'Footer.php';
    ?>