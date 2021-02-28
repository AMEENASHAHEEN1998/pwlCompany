<?php
/*
** member page
** can add | delete | edit | update | manage
*/
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='التواصل';
        include 'init.php';
        $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
        if($do == "Manage"){

            
            
            // select all user in db without admin
            $stmt = $con->prepare("SELECT * from pwlcompany.call_us  ORDER BY pwlcompany.call_us.id DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if(! empty($rows)){

            
            ?>
            <h2 class=" text-center"  >صفحة التواصل </h2>
            <div class ='container'>
                <div class = 'table-responsive'>
                    <table class = 'main-table manage-members text-center table table-bordered'>
                        <tr>
                            <td>#الرقم</td>
                            
                            <td>اسم المستخدم</td>
                            <td>الايميل</td>
                            <td>الموضوع</td>
                            <td>الرسالة</td>
                            <td>التواصل</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['subject'] . "</td>";
                                    echo "<td>" . $row['message'] ."</td>";
                                    echo "<td>
                                                
                                                <a href='call_us.php?do=Delete&userid=". $row['id'] ." ' class='btn btn-danger confirm btnPadd'><i class='fa fa-close'></i> Delete</a>";
                                                if($row['call_us'] == 0){
                                                echo "<a href='call_us.php?do=Active&userid=". $row['id'] ." ' class='btn btn-info btnPadd active'><i class='fa fa-check'></i> Call </a>";
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
                    echo '<div class="nice-message">لا يوجد أي تواصل </div>';
                    
                echo '</div>';
            }
        }
        
        elseif($do == 'Delete'){ // delete page member

            echo "<h2 class='text-center'>حذف التواصل</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('id','pwlcompany.call_us',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("DELETE FROM pwlcompany.call_us WHERE id = :zuserid ");
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

            echo "<h2 class='text-center'>Active Member</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('id','pwlcompany.call_us',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("UPDATE  pwlcompany.call_us SET call_us = 1 where id = ?");
                    
                    $stmt->execute(array($userid));
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم التواصل".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "لا يوجد رسالة بهذا الرقم";
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
