<?php require '../config/connection.php';?>


<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="reservation-form" method="POST" role="search" action="../admin-actions/register_admin_action.php">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Register</h4>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Admin Name</label>
                                <input type="text" name="adminname" class="adminname" placeholder="adminname" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Email</label>
                                <input type="text" name="email" class="email" placeholder="email" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Password</label>
                                <input type="password" name="password" class="password" placeholder="password" autocomplete="on" required>
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

<?php require '../includes/footer.php'; ?>
