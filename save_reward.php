<?php
header("Content-Type:application/json");
require "config/index.php";

$data = json_decode(file_get_contents("php://input"));
$title = mysqli_real_escape_string($conn, $data->title);
$gameName = mysqli_real_escape_string($conn, $data->game_name);
$rewardUrl = mysqli_real_escape_string($conn, $data->reward_url);
$isRedeemCode = mysqli_real_escape_string($conn, $data->is_redeem_code);
$isGameLink = mysqli_real_escape_string($conn, $data->is_game_link);
$time = mysqli_real_escape_string($conn, $data->time);
$date = mysqli_real_escape_string($conn, $data->date);


if ($title && $gameName && $rewardUrl) {

    $sql = "INSERT INTO rewards (title, game_name, reward_url, is_redeem_code, is_game_link, time, date) 
    VALUES ('$title', '$gameName', '$rewardUrl', '$isRedeemCode', '$isGameLink', '$time','$date')";

    if ($conn->query($sql)) {
        response(200, "Reward Added Successfully", null);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        response(201, "Can't Add Reward At The Moment", "Error: " . $sql . "<br>" . $conn->error);
    }
} else {
    response(201, "Missing Data", $data);
}

