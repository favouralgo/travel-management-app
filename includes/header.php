<?php

session_start();
define("APPURL","http://localhost/wooxtravel/");
define("REGIONIMAGES","http://localhost/wooxtravel/admin-panel/regions-admins/uploads/");
define("CITYIMAGES","http://localhost/wooxtravel/admin-panel/cities-admins/city_images/");

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Woox Travel </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo APPURL;?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="<?php echo APPURL;?>assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>assets/css/owl.css">
    <link rel="stylesheet" href="<?php echo APPURL;?>assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  </head>

<body>


  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.php" class="logo">
                        <img src="<?php echo APPURL;?>assets/images/logo.png" alt="">
                    </a>
                    <!-- ***** Logo End ***** -->

                    
                    <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                        <li><a href="<?php echo APPURL;?>index.php">Home</a></li>
                        <li><a href="<?php echo APPURL;?>deals.php">Deals</a></li>

                        <!--User Menu-->
                        <?php if (isset($_SESSION['username'])): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?php echo $_SESSION['username']; ?>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item text-black" href="<?php echo APPURL; ?>users/dashboard.php?id=<?php echo $_SESSION['user_id'];?>">Dashboard</a></li>
                                        <li><a class="dropdown-item text-black" href="<?php echo APPURL; ?>auth/logout.php">Logout</a></li>
                                    </ul>
                                </li>
                          <?php else: ?>
                        <li><a href="<?php echo APPURL;?>auth/login.php">Login</a></li>
                        <li><a href="<?php echo APPURL;?>auth/register.php">Register</a></li>
                        <?php endif; ?> 
                      </ul>   
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
  </html>