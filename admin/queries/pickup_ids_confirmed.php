<?php
$pickup_requests = array();

$pickup_new= mysqli_query($con, "SELECT id FROM pickup WHERE  status = 2 ORDER BY `pickup`.`id` DESC");

while ($row = mysqli_fetch_array($pickup_new)) {

    array_push($pickup_requests, $row['id']);

}
