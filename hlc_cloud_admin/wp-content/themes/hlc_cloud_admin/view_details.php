<?php
/**
 * The main template file
 * Template Name: View Details
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hlc_cloud_admin
 */

if (!isset($_SESSION['username'])) {
     header('Location: ' . $_SERVER['HTTP_REFERER']);
}
function get_all_users($conn){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
         $sql = "SELECT * from heat_load_subscription ORDER BY id DESC;";
         $result = mysqli_query($conn, $sql);
         return $result;
        }
}

try{
   include get_template_directory() . '/db_con.php';
    if ($conn->connect_error) {
        echo json_encode(False);
    }
    // $response = get_all_users($conn);
}catch (Exception $e) {
    echo json_encode(False);
}

// Update Query

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $pid = $_POST['pid'];
    $mid = $_POST['mid'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $subscription_start = $_POST['subscription_start']; // Format: Y-m-d\TH:i (from input)
    $subscription_end = $_POST['subscription_end'];
    // Convert to MySQL datetime format
    $subscription_start = date('Y-m-d H:i:s', strtotime($subscription_start));
    $subscription_end = date('Y-m-d H:i:s', strtotime($subscription_end));
    $sql = "UPDATE heat_load_subscription SET 
            user_id = '$username',
            pid = '$pid',
            mid = '$mid',
            is_active = '$is_active',
            subscription_start = '$subscription_start',
            subscription_end = '$subscription_end'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Record updated successfully!";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}

get_header();
?>

<!-- Content Start -->
<div class="content">
    <!-- Table Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0">Responsive Table</h6>
                        <a href="update_details.php" class="btn btn-primary">Update Details</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Index No</th>
                                    <th scope="col">Subscription Start</th>
                                    <th scope="col">Subscription End</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $response = get_all_users($conn);
                                    if(mysqli_num_rows($response) > 0){
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($response)){?>

                                <tr>
                                    <th scope="row">
                                        <?php echo $count++;?>
                                    </th>
                                    <td>
                                        <?php echo $row['subscription_start'];?>
                                    </td>
                                    <td>
                                        <?php echo $row['subscription_end'];?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <!-- Trigger button with just ... -->
                                            <button class="btn btn-link text-dark no-arrow m-0 p-0"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                ...
                                            </button>

                                            <!-- Dropdown menu with two options -->
                                            <div class="dropdown-menu dropdown-menu-start mt-2 py-1">
                                                <a href="#" class="dropdown-item"
                                                    onclick="event.preventDefault(); toggleForm(<?php echo $row['id']; ?>);">
                                                    Update User
                                                </a>
                                                <!-- Update Button -->
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <tr id="formRow_<?php echo $row['id']; ?>" style="display: none;">
                                    <td colspan="8"> <!-- 8 columns to span full width -->
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                            <!-- Table header inside expanded form -->
                                            <table class="table mb-2">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>User Name</th>
                                                        <th>PID</th>
                                                        <th>MID</th>
                                                        <th>Active</th>
                                                        <th>Subscription Start</th>
                                                        <th>Subscription End</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="username" class="form-control"
                                                                value="<?php echo isset($row['username']) ? htmlspecialchars($row['username']) : ''; ?>"
                                                                required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="pid" class="form-control"
                                                                value="<?php echo $row['pid']; ?>" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="mid" class="form-control"
                                                                value="<?php echo $row['mid']; ?>" required>
                                                        </td>
                                                        <td>
                                                            <?php  $ischecked = "";if( $row['is_active']==1){$ischecked="checked";} ?>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" <?php echo $ischecked;
                                                                    ?>
                                                                onclick="updateStatus('
                                                                <?php echo $row['pid']; ?>','
                                                                <?php echo $row['user_id'];?>','
                                                                <?php echo $ischecked;?>');"
                                                                type="checkbox" role="switch"
                                                                id="flexSwitchCheckDefault">
                                                                <label class="form-check-label"
                                                                    for="flexSwitchCheckDefault"></label>
                                                            </div>
                                                        </td>

                                                        <?php
                                                                function formatDateTimeLocal($datetime) {
                                                                    if (!empty($datetime)) {
                                                                        return date('Y-m-d\TH:i', strtotime($datetime));
                                                                    }
                                                                    return '';
                                                                }
                                                                ?>

                                                        <td>
                                                            <input type="datetime-local" name="subscription_start"
                                                                class="form-control"
                                                                value="<?php echo formatDateTimeLocal($row['subscription_start']); ?>"
                                                                required>
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="subscription_end"
                                                                class="form-control"
                                                                value="<?php echo formatDateTimeLocal($row['subscription_end']); ?>"
                                                                required>
                                                        </td>
                                                        <td>
                                                            <button type="submit" name="update"
                                                                class="btn btn-success">Update</button>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </td>
                                </tr>


                                <?php 
                                        }
                                    }
                                    ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table End -->
</div>
<!-- Content End -->
</div>
<?php

get_footer();