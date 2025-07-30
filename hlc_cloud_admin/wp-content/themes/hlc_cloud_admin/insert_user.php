<?php
/**
 * The main template file
 * Template Name: Insert User
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hlc_cloud_admin
 */

// DB connection
include get_template_directory() . '/db_con.php';
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle insert
if (isset($_POST['insert'])) {
    $mid = $_POST['mid'];
    $pid = $_POST['pid'];
    $username = $_POST['username'];
    $user_type = $_POST['pid'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $subscription_start = date('Y-m-d H:i:s', strtotime($_POST['subscription_start']));
    $subscription_end = date('Y-m-d H:i:s', strtotime($_POST['subscription_end']));

    $sql = "INSERT INTO heat_load_subscription 
            (mid, pid, user_id, user_type, subscription_type, subscription_start, subscription_end, is_active)
            VALUES 
            ('$mid', '$pid', '$username', '$user_type', 'Free', '$subscription_start', '$subscription_end', '$is_active')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center'> User inserted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'> Error: " . mysqli_error($conn) . "</div>";
    }
}

get_header();
?>

<!-- Insert User Form Start -->
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4 w-100" style="max-width: 600px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="text-primary mb-0">Insert New User</h4>
                <p class="text-muted">Add a new HLC Cloud user</p>
            </div>
            <a href="<?php echo site_url('/hlc-users'); ?>" class="btn btn-outline-primary btn-sm">← Back</a>
        </div>

        <form method="POST">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="mid" class="form-label">MID</label>
                    <input type="text" class="form-control rounded-3" name="mid" id="mid" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="pid" class="form-label">PID</label>
                    <input type="text" class="form-control rounded-3" name="pid" id="pid" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="username" class="form-label">User ID</label>
                    <input type="text" class="form-control rounded-3" name="username" id="username" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="userType" class="form-label">User Type</label>
                    <select class="form-select rounded-3" name="user_type" id="userType" required>
                        <option disabled selected>Select user type</option>
                        <option value="Admin">Admin</option>
                        <option value="Editor">Editor</option>
                        <option value="Viewer">Viewer</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="subscriptionStart" class="form-label">Subscription Start</label>
                    <input type="datetime-local" class="form-control rounded-3" name="subscription_start"
                        id="subscriptionStart" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="subscriptionEnd" class="form-label">Subscription End</label>
                    <input type="datetime-local" class="form-control rounded-3" name="subscription_end"
                        id="subscriptionEnd" required>
                </div>

                <div class="mb-3 col-12 d-flex align-items-center">
                    <input class="form-check-input me-2" type="checkbox" name="is_active" id="isActive">
                    <label class="form-check-label" for="isActive">Is Active</label>
                </div>
            </div>

            <div class="d-grid py-3">
                <button type="submit" name="insert" class="btn btn-primary rounded-3">Insert User</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="<?php echo site_url('/hlc-users'); ?>" class="btn btn-outline-secondary btn-sm rounded-3">← Back to User List</a>
        </div>
    </div>
</div>
<!-- Insert User Form End -->
</div>
<?php

get_footer();