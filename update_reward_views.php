<?php
header("Content-Type:application/json");
require "config/index.php";

$data = json_decode(file_get_contents("php://input"));
$id = mysqli_real_escape_string($conn, $data->reward_id);
$device_id = mysqli_real_escape_string($conn, $data->device_id);
$platform = mysqli_real_escape_string($conn, $data->platform);


if ($id) {
 $total_pages_sql = "SELECT COUNT(*) as Count  FROM stats WHERE device_id  = '$device_id' and reward_id =$id";
 $result = mysqli_query($conn, $total_pages_sql);
 
 $result ?  $count = mysqli_fetch_assoc($result) : 0;
 $no = $count['Count'];
 if ($no <1 ) {
    $sql = "SELECT * FROM rewards where id = $id";
    $result = mysqli_query($conn, $sql);
    if($result){
        $reward = mysqli_fetch_assoc($result);
    }
    $views = $reward['views'] + 1;
    $sql = "UPDATE rewards SET views=$views WHERE id=$id";
    if ($conn->query($sql)) {

        $Add_stats_sql = "INSERT INTO `stats` (`is_viewed`, `is_opened`, `platform`, `device_id`,`reward_id`) VALUES (1, 1, '$platform', '$device_id', $id)";
        if($conn->query($Add_stats_sql)){}else{}
            $sql = "SELECT rs.* , s.is_opened as is_opened
        FROM rewards rs
        LEFT JOIN stats s
        ON rs.id = s.reward_id WHERE rs.id = $id";
        $result = mysqli_query($conn, $sql);
        if($result){
            $reward = mysqli_fetch_assoc($result);
        }
        response(200, "Success",  $reward);
    } else {
        response(201, "Can't Add Reward At The Moment", NULL);
    }

}else{ response(201, "Already Opened", '');}
} else {
    response(201, "Missing id", '');
}