<?php 
require "../layout/header.php";
require '../../config/connection.php';
 ?>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<title>Woox Travel </title>

<!-- Bootstrap core CSS -->
<link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Additional CSS Files -->
<link rel="stylesheet" href="../../assets/css/fontawesome.css">
<link rel="stylesheet" href="../../assets/css/templatemo-woox-travel.css">
<link rel="stylesheet" href="../../assets/css/owl.css">
<link rel="stylesheet" href="../../assets/css/animate.css">
<link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>

<div class="reservation-form">
    <div class="container">
      <div class="row">
        
        <div class="col-lg-12">
          <form id="reservation-form" method="POST" role="search" action="../admin-actions/login_admin_action.php">
            <div class="row">
              <div class="col-lg-12">
                <h4>Login</h4>
              </div>
              <div class="col-md-12">
                  <fieldset>
                      <label for="Name" class="form-label">Your Email</label>
                      <input type="email" name="email" class="Name" placeholder="email" autocomplete="on" required>
                  </fieldset>
              </div>

              <div class="col-md-12">
                <fieldset>
                    <label for="Name" class="form-label">Your Password</label>
                    <input type="password" name="password" class="Name" placeholder="password" autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">                        
                  <fieldset>
                      <button type="submit" name="submit" class="main-button">Login</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php require '../../includes/footer.php'; ?>
