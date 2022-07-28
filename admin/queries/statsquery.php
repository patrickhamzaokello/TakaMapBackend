<?php
//get number of $active_ins_sql
$active_ins_sql = mysqli_query($con, "SELECT COUNT(*) as active from infrastructure where status = 1");
$row = mysqli_fetch_array($active_ins_sql);
$active_ins = $row['active'];

//get number of $not_active_ins_sql
$not_active_ins_sql = mysqli_query($con, "SELECT COUNT(*) as notActive from infrastructure where status = 2");
$row = mysqli_fetch_array($not_active_ins_sql);
$not_active_ins = $row['notActive'];




