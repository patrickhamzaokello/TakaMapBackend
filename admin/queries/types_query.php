<?php
$infrastructure = array();

$infrastructure_new = mysqli_query($con, "SELECT * FROM `infrastructuretypes` ORDER BY `infrastructuretypes`.`name` ASC");

while ($row = mysqli_fetch_array($infrastructure_new)) {

    array_push($infrastructure, $row['id']);

}
