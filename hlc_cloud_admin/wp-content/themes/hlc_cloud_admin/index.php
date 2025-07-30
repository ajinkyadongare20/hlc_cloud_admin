<?php
/**
 * The main template file
 * Template Name: Home
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hlc_cloud_admin
 */

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'golden7') {
        $_SESSION['username'] = $username;

        // Detect environment and redirect accordingly
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            // For localhost
            header("Location: /wordpess_projects/hlc_cloud_users/hlc_cloud_users/view_user.php");
        } else {
            // For server
            header("Location: /demo-hlccloud/view_user.php");
        }
        exit;
    } else {
        echo "Login Failed";
    }
}

get_header();
?>

<!-- Login Form Start -->
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Login</h2>
            <p class="text-muted">Welcome back to HLC Cloud</p>
        </div>

        <form action="#" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control rounded-3" id="username" name="username"
                    placeholder="Enter username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control rounded-3" id="password" name="password"
                    placeholder="Enter password" required>
            </div>

            <div class="d-grid py-3">
                <input type="submit" class="btn btn-primary rounded-3" name="login" value="Login">
            </div>
        </form>

        <div id="error-msg" class="text-danger mt-3 text-center" style="display: none;">
            Invalid username or password
        </div>
    </div>
</div>
<!-- Login Form End -->
</div>


<!-- Login Validation -->
<script>
    function validateLogin() {
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        // Dummy validation — replace with real login check
        if (username === "admin" && password === "admin123") {
            alert("Login successful!");
            return true;
        } else {
            document.getElementById("error-msg").style.display = "block";
            return false;
        }
    }
</script>

<?php

get_footer();