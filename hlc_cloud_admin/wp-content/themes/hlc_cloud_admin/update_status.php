<?php 
function get_all_users($conn){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
        $current_date=date("Y-m-d h:i:s");
        $isActive = $_GET['is_active'];
        $pid = $_GET['pid'];
        $user_id = $_GET['user_id'];
        $sql = "UPDATE `heat_load_subscription` SET `is_active`='$isActive' WHERE user_id='$user_id' and pid='$pid'";
        $result = mysqli_query($conn, $sql);
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
?>
