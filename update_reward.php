<?php
header("Content-Type:application/json");
require "config/index.php";

$data = json_decode(file_get_contents("php://input"));
$id = mysqli_real_escape_string($conn, $data->reward_id);
$title = mysqli_real_escape_string($conn, $data->title);
$rewardUrl = mysqli_real_escape_string($conn, $data->reward_url);
$isRedeemCode = mysqli_real_escape_string($conn, $data->is_redeem_code);
$isGameLink = mysqli_real_escape_string($conn, $data->is_game_link);

if ($title && $id && $rewardUrl) {

	$total_pages_sql = "SELECT * FROM rewards WHERE id = $id";
	$result = mysqli_query($conn, $total_pages_sql);
	
	if (mysqli_num_rows($result) > 0) {

		$sql = "UPDATE `rewards` SET 
		`title` = '$title',
		`reward_url` = '$rewardUrl',
		`is_redeem_code` = '$isRedeemCode',
		`is_game_link` = '$isGameLink' 
		WHERE `id` = '$id'";


		if ($conn->query($sql)) {
			$db_data = array();
			$sql = "SELECT r.*, s.is_opened as isOpened FROM rewards r LEFT JOIN stats s ON r.id = s.reward_id where r.id = $id GROUP by r.id";
			$result = mysqli_query($conn, $sql);

			if ($result) {
				while ($row = mysqli_fetch_assoc($result)) {
					$db_data[] = $row;
				}
			}
			response(200, "Reward Updated Successfully", $db_data);
		} else {
			response(201, "Can't Update Reward At The Moment", "Error: " . $sql . "<br>" . $conn->error);
		}
	} else {
		response(201, "No Data Exist Against Your ID", $data);
	}
} else {
	response(201, "Missing Data", $data);
}
