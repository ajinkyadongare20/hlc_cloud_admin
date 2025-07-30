<?php
/**
 * The main template file
 * Template Name: Update Details
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
    die("❌ Connection failed: " . mysqli_connect_error());
}

// Fetch the latest user data
$id = 0;
$userData = [];
$pid = $_GET['pid'];
$sql = "SELECT * FROM heat_load_subscription where pid = '$pid' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    $pid = $userData['pid'];
}

// Handle update
if (isset($_POST['update'])) {
    $pid = $_POST['pid'];
    $username = $_POST['username'];
    $user_type = $_POST['user_type'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $subscription_start = date('Y-m-d H:i:s', strtotime($_POST['subscription_start']));
    $subscription_end = date('Y-m-d H:i:s', strtotime($_POST['subscription_end']));
    $remaining_count = $_POST['remaining_count'];
    $sql = "UPDATE heat_load_subscription SET 
                user_type = '$user_type',
                is_active = '$is_active',
                remaining_count = '$remaining_count',
                subscription_start = '$subscription_start',
                subscription_end = '$subscription_end'
            WHERE pid = '$pid' ";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success text-center'>✅ Record updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
}

get_header();
?>

<!-- Update User Form Start -->
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4 w-100" style="max-width: 600px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Update User</h2>
            <p class="text-muted">Modify existing user details</p>
        </div>

        <form method="POST">
            <input type="hidden" name="pid" value="<?= $pid ?>">

            <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control rounded-3" name="username" id="username" required
                    value="<?= isset($userData['user_id']) ? $userData['user_id'] : '' ?>">
            </div>

            <div class="mb-3">
                <label for="userType" class="form-label">User Type</label>
                <select class="form-select rounded-3" name="user_type" id="userType" required>
                    <option value="Single User" <?=(isset($userData['user_type']) &&
                        $userData['user_type']==='Single User' ) ? 'selected' : '' ?>>Single User</option>
                    <option value="Server User" <?=(isset($userData['user_type']) &&
                        $userData['user_type']==='Server User' ) ? 'selected' : '' ?>>Server User</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="remaining_count" class="form-label">Number of Login</label>
                <select class="form-select rounded-3" name="remaining_count" id="remaining_count" required>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?=(isset($userData['remaining_count']) &&
                        $userData['remaining_count']==$i) ? 'selected' : '' ?>>
                        <?= $i ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="subscriptionStart" class="form-label">Subscription Start</label>
                <input type="datetime-local" class="form-control rounded-3" name="subscription_start"
                    id="subscriptionStart" required
                    value="<?= isset($userData['subscription_start']) ? date('Y-m-d\TH:i', strtotime($userData['subscription_start'])) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="subscriptionEnd" class="form-label">Subscription End</label>
                <input type="datetime-local" class="form-control rounded-3" name="subscription_end" id="subscriptionEnd"
                    required
                    value="<?= isset($userData['subscription_end']) ? date('Y-m-d\TH:i', strtotime($userData['subscription_end'])) : '' ?>">
            </div>

            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                    <?=(isset($userData['is_active']) && $userData['is_active']==1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="isActive">Is Active</label>
            </div>

            <div class="d-grid py-2">
                <button type="submit" name="update" class="btn btn-primary rounded-3">Update User</button>
            </div>

            <div class="text-center mt-3">
                <a href="view_user.php" class="btn btn-outline-secondary btn-sm rounded-3">← Back to User List</a>
            </div>
        </form>
    </div>
</div>
<!-- Update User Form End -->

</div>
<?php

get_footer();