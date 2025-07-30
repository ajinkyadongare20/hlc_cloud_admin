<?php
/**
 * The main template file
 * Template Name: View All Pids
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
function get_all_users($conn,$pid){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
         $sql = "SELECT * from heat_load_subscription where pid='$pid' ORDER BY id DESC;";
         $result = mysqli_query($conn, $sql);
         return $result;
        }
}


try{
    $pid = $_GET['pid'];
    if($pid==''){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    include get_template_directory() . '/db_con.php';
    if ($conn->connect_error) {
        echo json_encode(False);
    }
    // $response = get_all_users($conn);
}catch (Exception $e) {
    echo json_encode(False);
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
                                <h6 class="mb-0">HLC Users</h6>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="view_user.php" class="btn btn-primary mx-1">← Back</a>
                                    <a href="update_details.php?pid=<?php echo $_GET['pid'];?>"
                                        class="btn btn-primary mx-1">Update Details</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">PID</th>
                                            <th scope="col">Board ID(M)</th>
                                            <th scope="col">Active</th>
                                            <th scope="col">Subscription Start</th>
                                            <th scope="col">Subscription End</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $pid = $_GET['pid'];
                                        $response = get_all_users($conn,$pid);
                                        if(mysqli_num_rows($response) > 0){
                                            $count = 1;
                                            while ($row = mysqli_fetch_assoc($response)){ ?>
                                        <tr>
                                            <th scope="row">
                                                <?php echo $count++; ?>
                                            </th>
                                            <td>
                                                <?php echo $row['user_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['pid']; ?></i>
                                            </td>
                                            <td>
                                                <?php echo $row['motherboard_id']; ?>
                                            </td>
                                            <td>
                                                <?php $ischecked = ($row['is_active'] == 1) ? "checked" : ""; ?>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" <?php echo $ischecked; ?>
                                                    type="checkbox" role="switch"
                                                    id="flexSwitchCheckDefault">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckDefault"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo $row['subscription_start']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['subscription_end']; ?>
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