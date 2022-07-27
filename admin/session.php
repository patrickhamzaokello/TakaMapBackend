<?php

if (!isset($_SESSION['login_user'])) {
    header("Location: login");
    exit;
} else {
    $user_check = $_SESSION['login_user'];

    $ses_sql = mysqli_query($con, "select username from users where Email = '$user_check' ");

    $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);

    if ($row) {
        $login_session = $row['username'];
    } else {
       return;
    }
}
