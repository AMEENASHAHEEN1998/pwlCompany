<?php 
    include 'init.php'; // include init file
    $serviesid = isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']): 0 ;
    $stmt = $con->prepare("SELECT * from pwlcompany.services WHERE id = ? ");
        $stmt->execute(array($serviesid));
        $rows = $stmt->fetchAll();
        $count = $stmt->rowCount();
        if(!empty($rows)){
    
        foreach($rows as $row){ 
?>

<!--Start Content Section-->
<section class="content-sec">
        <div class="container">
            <div class="title">
                <?php echo $row['name']; ?>
            </div>
            <div class="row">
                
                <div class="details col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h1><?php echo $row['name']; ?></h1>
                    <p><?php echo $row['description']; ?></p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php echo "<img src='admin/uploads/photo/" . $row['img'] . "'alt='' >"; ?>
                </div>
            </div>
        </div>
    </section>
    <!--End Content Section-->

<?php 
        }
    }
    include $tpl . 'Footer.php';
?>