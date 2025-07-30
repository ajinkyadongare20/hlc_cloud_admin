<?php
/**
 * The main template file
 * Template Name: View User
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
         $sql = "SELECT * from heat_load_subscription GROUP BY pid ORDER BY id DESC;";
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


get_header();
?>

<style>
    span.no_count {
        background-color: green;
        border-radius: 50%;
        padding: 3px;
        color: #fff;
    }
</style>

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
                            <a href="insert_user.php" class="btn btn-primary mx-1"><i class="fa fa-plus"
                                    aria-hidden="true"></i> New User</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="userTable" class="display">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">User Type</th>
                                    <th scope="col">PID</th>
                                    <th scope="col">Board ID(M)</th>
                                    <th scope="col">Active</th>
                                    <th scope="col">Subscription End</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $response = get_all_users($conn);
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
                                        <?php 
                                                    if($row['user_type']=='Server User'){ echo "<span class='no_count'>". $row['remaining_count']."</span>"; ?>
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                        <?php }?>
                                        <?php if($row['user_type']!=''){ ?>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <?php }?>

                                    </td>
                                    <td>
                                        <?php echo $row['pid']; ?><a
                                            href="view_all_pids.php?pid=<?php echo $row['pid'];?>"><i
                                                class="fas fa-eye green" aria-hidden="true"></i></a>
                                    </td>
                                    <td>
                                        <?php echo $row['motherboard_id']; ?>
                                    </td>
                                    <td>
                                        <?php  $ischecked = "";
                                                        if( $row['is_active']==1){$ischecked="checked";} ?>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" <?php echo $ischecked; ?>
                                            onclick="updateStatus('
                                            <?php echo $row['pid']; ?>','
                                            <?php echo $row['user_id'];?>','
                                            <?php echo $ischecked;?>');"
                                            type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $row['subscription_end']; ?>
                                    </td>
                                    <td>
                                        <a href="view_all_pids.php?pid=<?php echo $row['pid'];?>"><i class="fas fa-edit"
                                                style="color:#009cff85;"></i></a>
                                        <a href="delete_user.php?pid=<?php echo $row['pid']; ?>"
                                            onclick="return confirm('Are you sure you want to delete this user?');"><i
                                                class="fa fa-trash" aria-hidden="true" style="color:#ff0000a8;"></i></a>
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