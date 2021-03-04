<?php
    include 'init.php'; // include init file
?>

<!--Start Teamwork-->
<?php       
    $stmt = $con->prepare(" SELECT pwlcompany.requests.* ,pwlcompany.users.UserName as UserName , pwlcompany.users.img as photo 
    from pwlcompany.requests inner join pwlcompany.users 
    On pwlcompany.requests.userid =pwlcompany.users.UserId
    where pwlcompany.requests.accept = 1 AND pwlcompany.users.Status = 1   ");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if(! empty($rows)){

            
      ?>
    ?>
 
      <section class="team-sec">
          <div class="container">
              <div class="title">فريق عمل الشركة</div>
              <?php
                foreach($rows as $row){

                  echo '<div class="row">';
                    echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
                      echo '<div class="team-work">';
                        echo '<span class="title-job">' .$row["Job title"]. '</span>';
                        
                        echo "<div class=' full-view'>";
                          echo "<p>"; 
                              
                            if(empty($row['photo'])){
                                echo '<img class =" img-responsive"src= "../layout/image/avatar.png" alt =""/>';
                            }else{
                                echo "<img  src='admin/uploads/photo/" . $row['photo'] . "'alt=''>";
                            }
                          echo "</p>";

                        echo "</div>";
                        echo '<div class="details">';
                          echo '<h3 class="text-center">' .$row["UserName"]. '</h3>';
                          echo '<h4 class="text-center">'.$row["specialization"].'</h4>';
                        echo '</div>';
                    echo '</div>';
                  echo '</div>';  
                }
                }  
            

            ?>
          </div>
      </section>
    <!--End Teamwork-->

    
<?php
  include $tpl . 'Footer.php';
?>   