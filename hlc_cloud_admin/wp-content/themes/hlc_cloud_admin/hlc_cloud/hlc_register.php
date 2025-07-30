<?php 
include 'db_con.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$response_data = array("status"=>false,'message'=>"Something went wrong...!");
if($conn){
     $user_name = trim($_GET['user_name']);
     $mid = trim($_GET['mid']);
     $pid = trim($_GET['pid']);
     $motherboard_id = trim($_GET['mother_board_id']);
     $current_date=date("Y-m-d h:i:s");
     $sql = "SELECT * FROM heat_load_subscription WHERE `pid` = '$pid' and `motherboard_id`='$motherboard_id'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result)<5) {
        $sql = "INSERT INTO heat_load_subscription(`mid`, `pid`,`motherboard_id`,`user_id`,`is_active`, `created_at`, `updated_at`) VALUES ('$mid','$pid','$motherboard_id','$user_name','0','$current_date','$current_date')";
     if ($conn->query($sql) === TRUE){
        $response_data['status']=true;
        $response_data['message']="User inserted successfully...!";
     } else {
        $response_data['message']= $conn->error;
     }
    }
}
$conn->close();
echo json_encode($response_data); 
?>