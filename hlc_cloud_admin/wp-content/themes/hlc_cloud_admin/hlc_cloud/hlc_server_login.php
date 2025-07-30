<?php 
function call_to_server(){
    $url = "https://demo-hlccloud.lealsolution.com/demo-hlccloud/hlc_cloud/hlc_login.php?mid=".trim($_GET['mid'])."&pid=".trim($_GET['pid'])."&user_name=".trim($_GET['user_name'])."&mother_board_id=".trim($_GET['mother_board_id']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Origin: https://www.lealsolution.com/',
    'Referer: server_oriented'
    ]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        return false;
    } else {
        return $response;
    }
    curl_close($ch);
}
try{
    $response = call_to_server();
    if($response=="true"){
    echo json_encode(True);
    }else{
    echo json_encode(False);
    }
}catch (Exception $e) {
    echo json_encode(False);
}

?>