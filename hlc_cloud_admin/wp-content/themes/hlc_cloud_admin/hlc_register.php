<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_conn.php';
if($conn){
     $user_name = trim($_GET['user_name']);
     $mid = trim($_GET['mid']);
     $pid = trim($_GET['pid']);
     
     $current_date=date("Y-m-d h:i:s");
     $subscription_start = date('Y-m-d h:i:s');
     $subscription_end = date('Y-m-d h:i:s', strtotime('+1 day'));
     $sql = "SELECT * FROM heat_load_subscription WHERE `pid` = '$pid' and `mid`='$mid'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result)<=7) {
        $sql = "INSERT INTO heat_load_subscription(`mid`, `pid`, `user_id`,`is_active`, `subscription_start`,`subscription_end`,`created_at`, `updated_at`) VALUES ('$mid','$pid','$user_name','0','$subscription_start','$subscription_end','$current_date','$current_date')";
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