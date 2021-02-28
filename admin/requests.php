<?php
/*
** member page
** can add | delete | edit | update | manage
*/
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='طلبات الانتساب';
        include 'init.php';
        $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
        if($do == "Manage"){

            
            
            
            $stmt = $con->prepare("SELECT pwlcompany.requests.* , pwlcompany.users.UserName AS username 
            FROM pwlcompany.requests
            INNER JOIN pwlcompany.users on pwlcompany.users.UserId = pwlcompany.requests.userId
            
            ORDER BY pwlcompany.requests.idRequest DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if(! empty($rows)){

            
            ?>
            <h2 class=" text-center"  >طلبات الانتساب </h2>
            <div class ='container'>
                <div class = 'table-responsive'>
                    <table class = 'main-table manage-members text-center table table-bordered'>
                        <tr>
                            <td>#الرقم</td>
                            <td>صورة شخصية</td>
                            <td>اسم المستخدم</td>
                            <td>الايميل</td>
                            <td>رقم الجوال</td>
                            <td>التخصص الجامعي</td>
                            <td>المسمى الوظيفي</td>
                            <td>السيرة الذاتية</td>
                            <td>الموافقة</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['idRequest'] . "</td>";
                                    echo "<td>" . $row['img'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";//
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['phoneNumber'] . "</td>";
                                    echo "<td>" . $row['specialization'] ."</td>";
                                    echo "<td>" . $row['Job title'] ."</td>";
                                    echo "<td>" . $row['CV'] ."</td>";
                                    

                                    echo "<td>
                                                
                                                <a href='requests.php?do=Delete&userid=". $row['idRequest'] ." ' class='btn btn-danger confirm btnPadd'><i class='fa fa-close'></i> Delete</a>";
                                                if($row['accept'] == 0){
                                                echo "<a href='requests.php?do=Active&userid=". $row['idRequest'] ." ' class='btn btn-info btnPadd active'><i class='fa fa-check'></i> Accept </a>";
                                                }
                                                echo"</td>";
                                    
                                echo "</tr>";

                            }
                        ?>
                        
                    </table>
                </div>
            
            </div>
            
            <?php  
            }else {
                echo '<div class = "container">';
                    echo '<div class="nice-message">لا يوجد طلبات للانتساب   </div>';
                    
                echo '</div>';
            }
        }
        
        elseif($do == 'Delete'){ // delete page member

            echo "<h2 class='text-center'>حذف التواصل</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('idRequest','pwlcompany.requests',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("DELETE FROM pwlcompany.requests WHERE idRequest = :zuserid ");
                    $stmt->bindParam(":zuserid" , $userid);
                    $stmt->execute();
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم حذف الرسالة بنجاح".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "لا يوجد رسالة بهذا الرقم";
                        redirectPage($Msg);
                    echo '</div>';

                }
            echo'</div>';  
        }elseif($do == 'Active'){ // Active page member

            echo "<h2 class='text-center'>قبول طلب الانتساب </h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('idRequest','pwlcompany.requests',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("UPDATE  pwlcompany.requests SET accept = 1 where idRequest = ?");
                    
                    $stmt->execute(array($userid));
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم قبول الطلب ".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "لا يوجد طلب بهذا الرقم";
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
