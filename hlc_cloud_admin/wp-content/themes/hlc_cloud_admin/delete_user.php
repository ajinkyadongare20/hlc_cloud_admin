<?php
/**
 * The main template file
 * Template Name: Delete User
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package hlc_cloud_admin
 */

function get_all_users($conn){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
        $pid = $_GET['pid'];
         $sql = "DELETE from heat_load_subscription WHERE pid = '$pid'";;
         $result = mysqli_query($conn, $sql);
         return $result;
        }
}

try{
    include 'db_con.php';
    if ($conn->connect_error) {
        echo json_encode(False);
    }
    $response = get_all_users($conn);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
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
                    <h6 class="mb-4">Responsive Table</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">PID</th>
                                    <th scope="col">MID</th>
                                    <th scope="col">Active</th>
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
                                        <?php echo $row['user_id'];?>
                                    </td>
                                    <td>
                                        <?php echo $row['pid'];?>
                                    </td>
                                    <td>
                                        <?php echo $row['mid'];?>
                                    </td>
                                    <td>
                                        <?php  $ischecked = "";if( $row['is_active']==1){$ischecked="checked";} ?>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" <?php echo $ischecked; ?>
                                            type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault">
                                            <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                                        </div>
                                    </td>
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
                                                <!-- View Project -->
                                                <a href="view_user.php?id=<?php echo $row['id']; ?>"
                                                    class="dropdown-item">
                                                    View Project
                                                </a>
                                                <!-- Delete Project -->
                                                <a href="delete_project.php?pid=<?php echo $row['pid']; ?>"
                                                    class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this project?');">
                                                    Delete Project
                                                </a>
                                            </div>
                                        </div>
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


    <!-- Footer Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded-top p-4">
            <div class="row">
                <div class="col-12 col-sm-6 text-center text-sm-end">
                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a href="https://htmlcodex.com">Leal Software Solution</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->
</div>
<!-- Content End -->

</div>
<?php

get_footer();