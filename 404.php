<?php require "includes/header.php"; ?>
<?php require "config/connection.php"; ?>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-3"> <span class="text-danger">Opps!</span> Page not found.</p>
                <?php echo "<br>"; ?>
                <p class="lead">
                    The page you are looking for does not exist.
                  </p>
                  <?php echo "<br>"; ?>
                <a href="index.php" class="btn btn-primary">Go Home</a>
            </div>
        </div>
<?php require "includes/footer.php"; ?>