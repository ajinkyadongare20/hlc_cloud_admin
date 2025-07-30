<?php 
function check_login($referer,$conn){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
         $user_name = trim($_GET['user_name']);
         $mid = trim($_GET['mid']);
         $pid = trim($_GET['pid']);
         $motherboard_id = trim($_GET['mother_board_id']);
         $current_date=date("Y-m-d h:i:s");
         $sql = "SELECT * FROM heat_load_subscription WHERE `pid` = '$pid' and `mid` = '$mid' and `user_id` = '$user_name' and `motherboard_id`='$motherboard_id' and `is_active` = '1'";
         $result = mysqli_query($conn, $sql);
         if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                $remaining_count = $row['remaining_count'];
                if($referer=='server_oriented'){
                    if((int)$remaining_count<=0){
                        return false;
                    }        
                }
                $subscription_type = $row['subscription_type'];
                $subscription_end = $row['subscription_end'];
                $current_date = date('Y-m-d h:i:s');
                if($subscription_type=='Life Time'){
                    return true;        
                }
                if($subscription_end!=''){
                    if($current_date < $subscription_end){
                        if($referer=='server_oriented'){
                            update_login_count($user_name,$remaining_count,$conn);
                        }
                        return true;        
                    }
                }
            }
            return false;
        }else {
    	    return false;
    	 }
    }
}

function update_login_count($user_name,$count,$conn){
    if($conn){
        $current_date=date("Y-m-d h:i:s");
        $remaining_count = $count - 1;
        $sql = "UPDATE heat_load_subscription SET `remaining_count` = '$remaining_count', `updated_at` ='$current_date' WHERE `user_id` = '$user_name'";
        $result = mysqli_query($conn, $sql);
    }else{
        return false;
    }
}
try{
    include 'db_con.php';
    if ($conn->connect_error) {
        echo json_encode(False);
    }
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Not Set';
    $response = check_login($referer,$conn);
    if($response==true){
    echo json_encode(True);
    }else{
    echo json_encode(False);
    }
    $conn->close();
}catch (Exception $e) {
    echo json_encode(False);
}

?>