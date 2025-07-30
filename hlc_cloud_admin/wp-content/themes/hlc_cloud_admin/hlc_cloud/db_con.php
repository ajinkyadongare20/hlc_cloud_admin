<?php 

$host = "localhost";
$username = "u757823634_heatloadcloud";
$password = "Hlccloud@2025";
$database = "u757823634_heatloadcloud";
$conn = mysqli_connect($host, $username, $password, $database);
if ($conn->connect_error) {
    echo json_encode(False);
}


?>