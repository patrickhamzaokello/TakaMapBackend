<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['aim'])) {
        $errors['aim'] = 'Aim  is Required';
    }
    if (empty($_POST['type'])) {
        $errors['type'] = 'Type is Required';
    }
    if (empty($_POST['longitude'])) {
        $errors['longitude'] = 'longitude is Required';
    }   if (empty($_POST['latitude'])) {
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
} else {
    $data['success'] = false;
    $data['message'] = 'Infrastructure not Added';
}
echo json_encode($data);