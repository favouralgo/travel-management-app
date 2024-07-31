<?php
require '../includes/header.php'; 

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


<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="reservation-form" method="POST" role="search" action="../actions/register_action.php">
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
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" name="username" class="username" placeholder="Enter your name" value="<?= isset($signup_data['username']) ? htmlspecialchars($signup_data['username']) : '' ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Email</label>
                                <input type="text" name="email" class="email" placeholder="Enter your email" autocomplete="on" value="<?= isset($signup_data['email']) ? htmlspecialchars($signup_data['email']) : '' ?>" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Password</label>
                                <input type="password" name="password" class="password" placeholder="Your password" autocomplete="on" required>
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

<?php require '../includes/footer.php'; ?>
