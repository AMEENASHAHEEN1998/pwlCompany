<?php
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='لوحة التحكم';
        include 'init.php';
        /* Start Dashbored Page*/

        $latestNumber = 5 ;
?>

        <div class = "container home-stats text-center">
            <h2>لوحة التحكم</h2>
            <div class="row">
                
                <div class = "col-md-3">
                    <div class = "stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            عدد المستخدمين والمبرمجين المحتاجين تفعيل
                            <span><a href="users.php?do=Manage&page=Pending"><?php echo checkItem('Status','pwlcompany.users','!= 1') ?></a> </span>
                        </div>
                        <div class="info">
                            عدد المبرمجين
                            <span> <a href="users.php"> <?php echo countitemwithwhere('UserId' ,'pwlcompany.users' , 'Status' , 1) ?></a></span>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            عدد المشاريع
                            <span> <a href="project_request.php"> <?php echo countItem('id' ,'pwlcompany.project_request' ) ?></a></span>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            عدد طلبات الانتساب
                            <span><a href="requests.php"> <?php echo countItem('idRequest' ,'pwlcompany.requests' ) ?></a></span>
                        </div>
                    </div>
                </div>
                <div class = "col-md-3">
                    <div class = "stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            عدد طلبات الاتصال
                            <span><a href="call_us.php"> <?php echo countItem('id' ,'pwlcompany.call_us' , 'call_us = 0') ?></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container latest">
            <div class = "row">
                <div class="col-sm-6">
                    <div class="panel panel-default panalBG">
                        <div class="panel-heading">
                            
                            <i class="fa fa-users"></i> أخر <?php echo $latestNumber?> مشاريع
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class = "list-unstyled latest-users ">
                                <?php $latestUsers = getLatest("*" ,"pwlcompany.project_request" ,"id" ,$latestNumber);
                                if(! empty($latestUsers)){
                                    foreach($latestUsers as $user){
                                        echo "<li>".$user["name"] ."<a href='project_request.php?do=Edit&userid=".$user["id"]."'class='btn btn-success pull-right '><i class='far fa-edit'></i>Edit</a>";
                                        if($user['agree'] == 0){
                                            echo "<a href='project_request.php?do=Active&userid=". $user['id'] ." ' class='btn btn-info btnPadd active pull-right'><i class='fa fa-check'></i>Active</a>";
                                        }
                                    }
                                }else{
                                    echo "There\'s No Member To Show";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-default panalBG">
                        <div class="panel-heading">
                            
                            <i class="fa fa-users"></i> أخر <?php echo $latestNumber?> طلبات انتساب
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class = "list-unstyled latest-users ">
                                <?php $latestUsers = getLatestwithjoin('pwlcompany.requests.*' , 'pwlcompany.users.UserName' , 'username' , 'pwlcompany.requests' , 'pwlcompany.users' , 'pwlcompany.users.UserId' , 'pwlcompany.requests.userId' , 'pwlcompany.requests.idRequest' , 5);
                                if(! empty($latestUsers)){
                                    foreach($latestUsers as $request){
                                        echo "<li>".$request["username"] ."<a href='requests.php?do=Edit&userid=".$request["idRequest"]."'class='btn btn-success pull-right '><i class='far fa-edit'></i>Edit</a>";
                                        if($user['agree'] == 0){
                                            echo "<a href='requests.php?do=Active&userid=". $request['idRequest'] ." ' class='btn btn-info btnPadd active pull-right'><i class='fa fa-check'></i>Active</a>";
                                        }
                                    }
                                }else{
                                    echo "لا يوجد طلبات انتساب لعرضها";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class = "row">
                <div class="col-sm-6">
                    <div class="panel panel-default panalBG">
                        <div class="panel-heading">
                            
                            <i class="fa fa-users"></i> أخر <?php echo $latestNumber?> اتصالات
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class = "list-unstyled latest-users ">
                            <?php $latestUsers = getLatest('*' ,'pwlcompany.call_us' , 'id',  5);
                                if(! empty($latestUsers)){
                                    foreach($latestUsers as $call){
                                        echo "<li>".$call["subject"] ."<a href='call_us.php?do=Edit&userid=".$call["id"]."'class='btn btn-success pull-right '><i class='far fa-edit'></i>Edit</a>";
                                        if($call["call_us"] == 0){
                                            echo "<a href='call_us.php?do=Active&userid=". $call['id'] ." ' class='btn btn-info btnPadd active pull-right'><i class='fa fa-check'></i>Active</a>";
                                        }
                                    }
                                }else{
                                    echo "لا يوجد طلبات انتساب لعرضها";
                                }
                                ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
<?php

        /* End Dashbored Page*/ 
        include $tpl . 'Footer.php';

    }else{
        header('location:index.php');
        exit();
    }
    ob_end_flush();


    
    
