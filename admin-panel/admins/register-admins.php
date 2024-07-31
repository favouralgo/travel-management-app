<?php 
require "../layout/header.php"; 
require '../../config/connection.php'; 

$errors = [];
$signup_data = [];
$signup_success = false;


if (isset($_SESSION['signup_errors'])) {
    $errors = $_SESSION['signup_errors'];
    unset($_SESSION['signup_errors']);
}

if (isset($_SESSION['signup_data'])) {
    $signup_data = $_SESSION['signup_data'];
    unset($_SESSION['signup_data']);
}

if (isset($_SESSION['signup_success'])) {
    $signup_success = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Woox Travel</title>
    <!-- Bootstrap core CSS -->
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/css/templatemo-woox-travel.css">
    <link rel="stylesheet" href="../../assets/css/owl.css">
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
</html>

<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="reservation-form" method="POST" role="search" action="../admin-actions/register_admin_action.php">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Register</h4>
                        </div>
                        <?php if ($signup_success): ?>
                            <div class="the-success-message"><h2>Registration successful! You can now sign in.</h2></div>
                            <?php endif; ?>
                        <?php if (!empty($errors)): ?>
                        <div class="the-error-message">
                            <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Admin Name</label>
                                <input type="text" name="adminname" class="adminname" placeholder="Enter you name" autocomplete="on"  value="<?= isset($signup_data['adminname']) ? htmlspecialchars($signup_data['adminname']) : '' ?>"required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Email</label>
                                <input type="email" name="email" class="email" placeholder="email" autocomplete="on" value="<?= isset($signup_data['email']) ? htmlspecialchars($signup_data['email']) : '' ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Password</label>
                                <input type="password" name="password" class="password" placeholder="password" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="password" placeholder="Confirm your password" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" name="submit" class="main-button">Register</button>
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
    .the-success-message { 
        color: green; 
        margin-bottom: 10px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const successMessage = document.querySelector('.the-success-message');
        const errorMessage = document.querySelector('.the-error-message');

        if (successMessage) {
            setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
        }

        if (errorMessage) {
            setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
        }
    });
</script>
<?php require '../../includes/footer.php'; ?>
