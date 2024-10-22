<?php
require 'config/index.php';

$data = array();

if (isset($_GET['page_no'])) {
    $pageno = $_GET['page_no'];
} else {
    $pageno = 1;
}


$gameName = !empty($_GET['game_name']) ? $_GET['game_name'] : null;
$deviceId = !empty($_GET['device_id']) ? $_GET['device_id'] : "";
$noOfRecordsPerPage = !empty($_GET['no_of_records']) ? $_GET['no_of_records'] : 10;


if($gameName) {

        $offset = ($pageno - 1) * $noOfRecordsPerPage;

        $sql = "SELECT r.*, s.is_opened as is_opened 
                FROM rewards r 
                LEFT JOIN stats s 
                ON r.id = s.reward_id 
                AND s.device_id = '$deviceId' 
                WHERE r.game_name = '$gameName'
                ORDER BY r.id
                DESC LIMIT $offset, $noOfRecordsPerPage";


        $result = mysqli_query($conn, $sql);
        
        if($result) {

            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            response(200, "Success", $data);

        } else {
            response(200, "Success", $data);
        }

        mysqli_close($conn);
    

} else {
    response(201, "Missing Game Name", $data);
}
