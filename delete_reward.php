<?php
require 'config/index.php';

$id = isset($_GET['reward_id']) ? $_GET['reward_id'] : null;
$totalSqlPages = "SELECT * FROM rewards Where id = $id";
$result = mysqli_query($conn, $totalSqlPages);

if($id) {
    if (mysqli_num_rows($result) > 0) {

        $sql = "DELETE FROM `rewards` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if($result) {
            response(200, "Successfully Deleted", "");
        } else {
            response(201, "Facing Some Errors Try Again Later", "");
        }
    } else{
        response(201, "NO Data against Your Reward ID", "");
    }
} else {
    response(201, "Missing Reward ID", "");
}