<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

$target_dir  = '../assets/mapIcons/';
$db_target_dir  = 'assets/mapIcons/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST['type'])) {
        $errors['type'] = 'Type is Required';
    }


    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {

        $type = mysqli_real_escape_string($con, $_POST['type']);

        // generating image name
        $formatedname = strip_tags($type);
        $formatedname = str_replace(" ", "_", $formatedname);

        $temp = explode(".", $_FILES["inputfile"]["name"]);

        // setting image new file name
        $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
        $newfilename = stripslashes($formatedname . '_map_icon') . $postfix . '.' . end($temp);

        $targetPath = $target_dir . basename($newfilename);
        $db_targetPath = $db_target_dir . basename($newfilename);

        if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
            $query = mysqli_query($con, "INSERT INTO `infrastructuretypes`(`name`,`iconpath`)VALUES('$type','$db_targetPath')");

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