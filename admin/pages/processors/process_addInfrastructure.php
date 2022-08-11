<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];


if (isset($_POST['form_action'])) {

    $action = $_POST['form_action'];

    if ($action == 1) {

        if (empty($_POST['aim'])) {
            $errors['aim'] = 'Aim  is Required';
        }
        if (empty($_POST['type'])) {
            $errors['type'] = 'Type is Required';
        }
        if (empty($_POST['longitude'])) {
            $errors['longitude'] = 'longitude is Required';
        }
        if (empty($_POST['latitude'])) {
            $errors['latitude'] = 'latitude is Required';
        }
        if (empty($_POST['description'])) {
            $errors['description'] = 'description is Required';
        }

        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors'] = $errors;
        } else {

            $aim = mysqli_real_escape_string($con, $_POST['aim']);
            $type = mysqli_real_escape_string($con, $_POST['type']);
            $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
            $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
            $description = mysqli_real_escape_string($con, $_POST['description']);


            $query = mysqli_query($con, "INSERT INTO `infrastructure`(`aim`, `description`, `longitude`, `latitude`, `type`)VALUES('$aim','$description','$longitude','$latitude','$type')");

            if ($query) {

                $data['success'] = true;
                $data['message'] = 'Infrastructure Added!';

            } else {
                $data['success'] = false;
                $data['message'] = 'Infrastructure not Added';
            }

        }

    } elseif ($action == 2) {

        // if update btn is click
        if (isset($_POST['type_id'])) {

            $type_id =mysqli_real_escape_string($con, $_POST['type_id']);


            $aim = mysqli_real_escape_string($con, $_POST['aim']);
            $type = mysqli_real_escape_string($con, $_POST['type']);
            $longitude = mysqli_real_escape_string($con, $_POST['longitude']);
            $latitude = mysqli_real_escape_string($con, $_POST['latitude']);
            $description = mysqli_real_escape_string($con, $_POST['description']);


            $query = mysqli_query($con, "UPDATE `infrastructure` SET `aim`='$aim', `description`='$description', `longitude`='$longitude', `latitude`='$latitude', `type`='$type' WHERE  `id` = $type_id");

            if ($query) {

                $data['success'] = true;
                $data['message'] = 'Infrastructure Added!';

            } else {
                $data['success'] = false;
                $data['message'] = 'Infrastructure not Added';
            }


        } else {

            $data['success'] = false;
            $data['message'] = 'Infrastructure Type not Updated';
        }
    } elseif ($action == 3) {

        //delete btn clicked

        if (isset($_POST['type_id'])) {

            $type_id =mysqli_real_escape_string($con, $_POST['type_id']);


            $delete_type_sql = "DELETE FROM `infrastructure` WHERE  `id` = $type_id";

            mysqli_query($con, $delete_type_sql);

            $affected_rows = mysqli_affected_rows($con);

            if ($affected_rows >= 1) {
                $data['success'] = true;
                $data['message'] = $affected_rows . ' Infrastructure Deleted! ';
            } else if ($affected_rows <= 0) {
                $data['success'] = false;
                $data['message'] = 'Infrastructure Type Not Deleted';
            }
        } else {
            $data['success'] = false;
            $data['message'] = 'Infrastructure Type not Passed';
        }
    }
} else {
    $data['success'] = false;
    $data['message'] = 'Undetermined Function';
}


echo json_encode($data);
