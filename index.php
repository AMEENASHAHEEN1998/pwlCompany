<?php
    

    session_start();
    include 'init.php'; // include init file
    echo $_SESSION['uid'];
    ?>

    
    <!-- start header section -->
    <section class="header-sec">
      <div class="overlay">
        <div class="container header-caption">
          <h1 class="text-left">شركة مبرمجون بلا حدود</h1>
        <p class="text-muted text-left">شركة مبرمجون بلا حدود هي شركة برمجية تهدف الى تطوير مهارات طلاب البرمجةو تنمية قدراتهم و رفع خبراتهم </p>
        <a class="btn-info btn" href="#">تعرف أكثر</a>  
      </div>
      </div>
      <div class="header-img">

      </div>
    </section>
    <!--End header section-->

    <!--Start services section-->
    <section class="services-sec">
        <div class="container">
          <div class="title">الخدمات</div> 
            
            
          <div class="row">
            <div class="boxes">
              <?php $stmt = $con->prepare("SELECT * from pwlcompany.services limit 3 offset 0 ");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if(!empty($rows)){
                
              
              foreach($rows as $row){ ?>
              
              <div class="col-lg-4 box1">
              <?php echo "<img src='admin/uploads/photo/" . $row['img'] . "'alt='' width='61' height='53' viewBox='0 0 61 53'>"; ?>

                    <h1> <?php echo $row['name']?></h1>
                </div>
              <?php 
              
               }
                }else{
                echo "لا يوجد خدمات لعرضها";
                }?>
            </div>
          </div>
          <div class="row">
            <div class="boxes">
              <?php $stmt = $con->prepare("SELECT * from pwlcompany.services limit 3 offset 3 ");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();
                if(!empty($rows)){
                
              
              foreach($rows as $row){ ?>
              
              <div class="col-lg-4 box1">
              <?php echo "<img src='admin/uploads/photo/" . $row['img'] . "'alt='' width='61' height='53' viewBox='0 0 61 53'>"; ?>

                    <h1> <?php echo $row['name']?></h1>
                </div>
              <?php 
              
              }
                }?>
            </div>
          </div>
              
            </div>
        </div>
    </section>
    <!--End services section-->
    <!--Start fixed items-->
    <section class="fixed">
      <div class="container">
        <a class="btn btn-warning btn-fix" href="request_project.php">
          اطلب مشروعك
        </a>
      </div>
    </section>
    <!--End fixed items-->

    <!--Start features section-->
  <section class="features-sec">
      <div class="container">
        <div class="title">بماذا نتميز؟</div>
        <?php $stmt = $con->prepare("SELECT * from pwlcompany.distinction ");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
            ?>
          <div class="row">
            <div class="boxes">
              <?php foreach($rows as $row){ ?>
              <div class="col-lg-3 box1">
                
                <?php echo "<img src='admin/uploads/photo/" . $row['img'] . "'alt='' width='61' height='53' viewBox='0 0 61 53'>"; ?>
                
                 <h1><?php echo $row['name']?></h1>
              </div>
              <?php }?>
            </div>
          </div>
     <?php }else{
       echo "لا يوجد مميزات لعرضها";
       }?>
      </div>
  </section>
    <!--End features section-->

    <!--Start Project Application-->
      <section class="app-sec">
        <div class="container">
          <div class="title">
            اطلب مشروعك
          </div>
        </div>
          <div class="container-fluid">
          <div class="app-img">
            <div class="overlay">
              <div class="app-caption text-center">
                <h1>هل تريد طلب مشروع ؟</h1>
                <p>ماذا تنتظر ؟ اطلب الآن!</p>
                <a class="btn btn-warning btn-app">اطلب الآن</a>
              </div>
            </div>
          </div>            
          </div>
        </div>
      </section>
    <!--End Project Application-->
    

<?php
    include $tpl . 'Footer.php';
    ?>