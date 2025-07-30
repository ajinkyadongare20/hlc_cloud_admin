<?php 
function check_login($referer,$conn){
    $response_data = array("status"=>false,'message'=>"Something went wrong...!");
    if($conn){
         $user_name = trim($_GET['user_name']);
         $mid = trim($_GET['mid']);
         $pid = trim($_GET['pid']);
         $motherboard_id = trim($_GET['mother_board_id']);
         $current_date=date("Y-m-d h:i:s");
         $sql = "SELECT * FROM heat_load_subscription WHERE `pid` = '$pid' and `user_id` = '$user_name' and `motherboard_id`='$motherboard_id' and `is_active` = '1'";
         $result = mysqli_query($conn, $sql);
         if(mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                $remaining_count = $row['remaining_count'];
                if($referer=='server_oriented'){
                    update_login_count($user_name,$remaining_count,$referer);
                    return true;      
                }else{
                    
                    update_login_count($user_name,$remaining_count,$referer);
                    return true;
                }
                return true;      
            }
            return false;
        }else {
    	    return false;
    	 }
    }
}

function update_login_count($user_name,$count,$referer){
    include 'db_con.php';
    if($conn){
        $current_date=date("Y-m-d h:i:s");
        $remaining_count = (int)$count + 1;
        if($remaining_count>6){
            $remaining_count = 5;
        }
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