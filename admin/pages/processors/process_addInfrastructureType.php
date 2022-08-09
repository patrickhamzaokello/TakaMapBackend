<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST['type'])) {
        $errors['type'] = 'Type is Required';
    }


    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {

        $type = mysqli_real_escape_string($con, $_POST['type']);


        $query = mysqli_query($con, "INSERT INTO `infrastructuretypes`(`name`)VALUES('$type')");

        if ($query) {

            $data['success'] = true;
            $data['message'] = 'Infrastructure Type Added!';

        } else {
            $data['success'] = false;
            $data['message'] = 'Infrastructure Type not Added';
        }
    }
} else {
    $data['success'] = false;
    $data['message'] = 'Infrastructure Type not Added';
}
echo json_encode($data);