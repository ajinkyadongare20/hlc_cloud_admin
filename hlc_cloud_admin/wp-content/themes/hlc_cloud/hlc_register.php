<?php 
$host = "localhost";
$username = "root";
$password = "";
$database = "hlc_cloud_users";
$conn = mysqli_connect($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$response_data = array("status"=>false,'message'=>"Something went wrong...!");
if($conn){
     $user_name = trim($_GET['user_name']);
     $mid = trim($_GET['mid']);
     $pid = trim($_GET['pid']);
     $current_date=date("Y-m-d h:i:s");
     $sql = "SELECT id FROM heat_load_subscription WHERE `pid` = '$pid' and `mid`= $mid";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result)<=0) {
        $sql = "INSERT INTO heat_load_subscription(`mid`, `pid`, `user_id`,`is_active`, `created_at`, `updated_at`) VALUES ('$mid','$pid','$user_name','0','$current_date','$current_date')";
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



---------------------------
Microsoft Excel
---------------------------
Login URL : https://demo-hlccloud.lealsolution.com/demo-hlccloud/hlc_login.php?mid= 1C:BF:CE:20:60:89&pid=BFEBFBFF000306A9&user_name=ajinkay
---------------------------
OK   
---------------------------

?>