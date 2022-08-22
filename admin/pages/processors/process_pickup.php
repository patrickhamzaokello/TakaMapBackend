<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];


if (isset($_POST['form_action'])) {

    $action = $_POST['form_action'];

    if ($action == 1) {

       // action to create

    } elseif ($action == 2) {

        // if update btn is click
        if (isset($_POST['pickup_id'])) {

            $pickup_id =mysqli_real_escape_string($con, $_POST['pickup_id']);
            $query = mysqli_query($con, "UPDATE `pickup` SET  `status`='2' WHERE  `id` = $pickup_id");

            if ($query) {

                $data['success'] = true;
                $data['message'] = 'Pickup Request Confirmed!';

            } else {
                $data['success'] = false;
                $data['message'] = 'Pickup Request not Confirmed';
            }


        } else {

            $data['success'] = false;
            $data['message'] = 'Pickup Request status not Updated';
        }
    } elseif ($action == 3) {

        //delete btn clicked

        if (isset($_POST['pickup_id'])) {

            $pickup_id =mysqli_real_escape_string($con, $_POST['pickup_id']);


            $delete_type_sql = "DELETE FROM `pickup` WHERE  `id` = $pickup_id";

            mysqli_query($con, $delete_type_sql);

            $affected_rows = mysqli_affected_rows($con);

            if ($affected_rows >= 1) {
                $data['success'] = true;
                $data['message'] = $affected_rows . ' Pickup Request Deleted! ';
            } else if ($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Pickup Request Not Deleted';
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Pickup Request ID  not Passed';
        }
    }
} else {
    $data['success'] = false;
    $data['message'] = 'Undetermined Function';
}


echo json_encode($data);
