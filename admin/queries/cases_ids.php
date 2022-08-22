<?php
$cases_requests = array();

$cases_new= mysqli_query($con, "SELECT id FROM cases WHERE  status = 1 ORDER BY  `cases`.`id` DESC ");

while ($row = mysqli_fetch_array($cases_new)) {

    array_push($cases_requests, $row['id']);

}
