<!-- start nav section -->

<section class="nav-sec">
      <nav class="navbar navbar-default">
          <div class="container">
              <div class="row">
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                              data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="#">مبرمجون بلا حدود</a>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  
                          <ul class="nav navbar-nav navbar-right">
                              <li class="active"><a href="index.php">الرئيسية</a></li>
                              <li><a href="about.php">من نحن</a></li>
                              <li><a href="team.php">فريق العمل</a></li>
                              <li class="dropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                      aria-haspopup="true" aria-expanded="false">خدماتنا <span
                                          class="caret"></span></a>
                                  <ul class="dropdown-menu">
                                  <?php $stmt = $con->prepare("SELECT * from pwlcompany.services  ");
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        $count = $stmt->rowCount();
                                        if(!empty($rows)){
                                        
                                    
                                            foreach($rows as $row){ 
                                                
                                                
                                                echo "<li><a href='service.php?id=".$row['id'] . " '> ". $row['name'] . "</a></li>";
                                            }
                                        }?>


                                      
                                      
  
                                  </ul>
                              </li>
                              <li><a href="contact.php">اتصل بنا</a></li>
                              
                              
                              <li><a href='affiliation.php?id=<?php echo $_SESSION['uid']; ?>'>  الانتساب</a></li>

                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                      <div class="icons">
                          <a href=""><i class="fa fa-facebook-f fa-2x"></i></a>
                          <a href=""><i class="fa fa-whatsapp fa-2x"></i></a>
                          <a href=""><i class="fa fa-instagram fa-2x"></i></a>
                      </div>
                  </div>
              </div>
          </div>
      </nav>
  </section>
    <!-- End nav section -->