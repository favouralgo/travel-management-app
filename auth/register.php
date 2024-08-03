<?php
require '../includes/header.php'; 
require "../config/core.php";

$errors = [];
$signup_data = [];
$signup_success = false;

?>

<div class="reservation-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="reservation-form" name="gs" role="search" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Register</h4>
                        </div>
                        <div id="message"></div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" name="username" id="username" class="username" placeholder="Enter your name" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Email</label>
                                <input type="text" name="email" id="email" class="email" placeholder="Enter your email" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Your Password</label>
                                <input type="password" name="password" id="password" class="password" placeholder="Your password" autocomplete="on" required>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                            <fieldset>
                                <label for="Name" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="password" placeholder="Confirm your password" autocomplete="on" required>
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
    .error-message { 
        color: red; 
        margin-bottom: 10px;
    }
    .success-message { 
        color: green; 
        margin-bottom: 10px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#reservation-form').submit(function(e) {
        e.preventDefault();
        
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        
        $.ajax({
            url: '../actions/register_action.php',
            type: 'POST',
            data: {
                username: username,
                email: email,
                password: password,
                confirm_password: confirm_password
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#message').html('<div class="success-message">' + response.message + '</div>');
                    $('#reservation-form')[0].reset();
                    setTimeout(function() {
                        window.location.href = '../auth/login.php';
                    }, 3000);
                } else {
                    var errorHtml = '<div class="error-message"><ul>';
                    $.each(response.errors, function(index, error) {
                        errorHtml += '<li>' + error + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    $('#message').html(errorHtml);
                }
            },
            error: function() {
                $('#message').html('<div class="error-message">An error occurred. Please try again.</div>');
            }
        });
    });
});
</script>

<?php require '../includes/footer.php'; ?>