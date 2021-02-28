<?php
/*
** member page
** can add | delete | edit | update | manage
*/
    ob_start(); // output buffering start
    session_start();
    if(isset($_SESSION['UserName'])){
        $pageTitle ='عرض المشاريع';
        include 'init.php';
        $do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage';
        if($do == "Manage"){

            
            
            
            $stmt = $con->prepare("SELECT pwlcompany.project_request.* , pwlcompany.services.name AS serviceName 
            FROM pwlcompany.project_request
            INNER JOIN pwlcompany.services on pwlcompany.services.id = pwlcompany.project_request.service_id
            
            ORDER BY pwlcompany.project_request.id DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            

            if(! empty($rows)){

            
            ?>
            <h2 class=" text-center"  >عرض المشاريع </h2>
            <div class ='container'>
                <div class = 'table-responsive'>
                    <table class = 'main-table manage-members text-center table table-bordered'>
                        <tr>
                            <td>#الرقم</td>
                            
                            <td>اسم المستخدم</td>
                            <td>الايميل</td>
                            <td>رقم الجوال</td>
                            <td>نوع الخدمة</td>
                            <td>وصف المشروع</td>
                            <td>الموافقة</td>
                        </tr>
                        <?php
                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['PhoneNumber'] . "</td>";
                                    echo "<td>" . $row['description_project'] . "</td>";
                                    echo "<td>" . $row['serviceName'] . "</td>";
                                    
                                    echo "<td>
                                                
                                                <a href='project_request.php?do=Delete&userid=". $row['id'] ." ' class='btn btn-danger confirm btnPadd'><i class='fa fa-close'></i> Delete</a>";
                                                if($row['agree'] == 0){
                                                echo "<a href='project_request.php?do=Active&userid=". $row['id'] ." ' class='btn btn-info btnPadd active'><i class='fa fa-check'></i> Accept </a>";
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
                    echo '<div class="nice-message">لا يوجد أي مشاريع  </div>';
                    
                echo '</div>';
            }
        }
        
        elseif($do == 'Delete'){ // delete page member

            echo "<h2 class='text-center'>حذف المشروع</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('id','pwlcompany.project_request',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("DELETE FROM pwlcompany.project_request WHERE id = :zuserid ");
                    $stmt->bindParam(":zuserid" , $userid);
                    $stmt->execute();
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم حذف المشروع بنجاح".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "لا يوجد مشروع بهذا الرقم";
                        redirectPage($Msg);
                    echo '</div>';

                }
            echo'</div>';  
        }elseif($do == 'Active'){ // Active page member

            echo "<h2 class='text-center'>قبول المشروع</h2> ";
            echo "<div class = 'container' >" ;

                // check if GET request user id is number and get userid value
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ;
                
                $check = checkItem('id','pwlcompany.project_request',$userid);
                // if there is such id show the form 
                if($check > 0){
                    $stmt = $con->prepare("UPDATE  pwlcompany.project_request SET agree = 1 where id = ?");
                    
                    $stmt->execute(array($userid));
                    $Msg='<div class= "alert alert-success">'. $stmt->rowCount() . "تم قبول المشروع".'</div>';
                    redirectPage($Msg,'back' , 5);
                    
                }else{
                    echo '<div class = "container">'; 
                        $Msg = "لا يوجد مشروع بهذا الرقم";
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
