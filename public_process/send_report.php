<?php
require("../admin/config.php");
$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];


if (empty($_POST['Name'])) {
    $errors['Name'] = 'Name  is Required';
}
if (empty($_POST['Contact'])) {
    $errors['Contact'] = 'Contact is Required';
}
if (empty($_POST['Address'])) {
    $errors['Address'] = 'Address is Required';
}
if (empty($_POST['Title'])) {
    $errors['Title'] = 'Title is Required';
}
if (empty($_POST['Description'])) {
    $errors['Description'] = 'Description is Required';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {

    $Name = mysqli_real_escape_string($con, $_POST['Name']);
    $Contact = mysqli_real_escape_string($con, $_POST['Contact']);
    $Address = mysqli_real_escape_string($con, $_POST['Address']);
    $Title = mysqli_real_escape_string($con, $_POST['Title']);
    $Description = mysqli_real_escape_string($con, $_POST['Description']);


    $query = mysqli_query($con, "INSERT INTO `cases`(`name`, `Contact`, `location`, `title`, `description`) VALUES ('$Name','$Contact','$Address','$Title','$Description')");

    if ($query) {

        $data['success'] = true;
        $data['message'] = 'Case Submitted!';

    } else {
        $data['success'] = false;
        $data['message'] = 'Case not Submitted';
    }

}


echo json_encode($data);
