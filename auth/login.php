<?php
require '../includes/header.php';
?>

<div class="reservation-form">
    <div class="container">
      <div class="row">
        
        <div class="col-lg-12">
          <form id="reservation-form" method="POST" role="search" action="../actions/login_action.php">
            <div class="row">
              <div class="col-lg-12">
                <h4>Login</h4>
              </div>
              <?php
                // Display login errors if any using PHP sessions
                if (isset($_SESSION['login_errors'])) {
                    foreach ($_SESSION['login_errors'] as $error) {
                        echo "<div class='the-error-message'>$error</div>";
                    }
                    unset($_SESSION['login_errors']);
                }
              ?>
              <div class="col-md-12">
                  <fieldset>
                      <label for="Name" class="form-label">Your Email</label>
                      <input type="text" name="email" class="Name" placeholder="email" autocomplete="on" required>
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
                      <button name="submit" type="submit" class="main-button">Login</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <style>
    .the-error-message { 
        color: red; 
        margin-bottom: 10px;
      }
  </style>
  <!--The JavaScript snippet below ensures the error and success message disappears after 5 seconds -->
  <script>
        document.addEventListener("DOMContentLoaded", function() {
            const errorMessage = document.querySelector('.the-error-message');

            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
  </script>

<?php require '../includes/footer.php';?>
