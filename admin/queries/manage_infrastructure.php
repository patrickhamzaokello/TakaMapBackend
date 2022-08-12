<?php
$infrastructure = array();

$infrastructure_new = mysqli_query($con, "SELECT id FROM infrastructure WHERE  status = 1 ORDER BY `infrastructure`.`InstallDate` DESC");

while ($row = mysqli_fetch_array($infrastructure_new)) {

    array_push($infrastructure, $row['id']);

}
