<?php
require "../../config.php";

$db = new Database();
$con = $db->getConnString();

$errors = [];
$data = [];

$target_dir = '../assets/mapIcons/';
$db_target_dir = 'assets/mapIcons/';

if (isset($_POST['form_action'])) {

    $action = $_POST['form_action'];

    if ($action == 1) {
        if (isset($_POST['type_name'])) {

            if (empty($_POST['type_name'])) {
                $errors['type_name'] = 'Type is Required';
            }


            if (!empty($errors)) {
                $data['success'] = false;
                $data['errors'] = $errors;
            } else {

                $type = mysqli_real_escape_string($con, $_POST['type_name']);

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
    } elseif ($action == 2) {

        // if update btn is click
        if (isset($_POST['type_id']) && isset($_POST['type_name'])) {
            $type_id = $_POST['type_id'];
            $type = mysqli_real_escape_string($con, $_POST['type_name']);

            if (empty($_FILES["inputfile"]["name"])) {
                $query = "UPDATE `infrastructuretypes` SET `name`='$type' WHERE  `id` = $type_id ";
                mysqli_query($con, $query);
                $name_change_rows = mysqli_affected_rows($con);
                if ($name_change_rows >= 1) {
                    $data['success'] = true;
                    $data['message'] = 'Infrastructure Type Name Only!';
                } else {
                    $data['success'] = false;
                    $data['message'] = 'Infrastructure Type Name Only Updated';
                }
            } else {
                $type_sql = mysqli_query($con, "SELECT iconpath FROM infrastructuretypes  WHERE  `id` = $type_id LIMIT 1");
                $row = mysqli_fetch_array($type_sql);
                if ($row != null) {
                    $mapIcon_image_path = $row['iconpath'];
                    $whole_image_path = "../" . $mapIcon_image_path;

                    // Use unlink() function to delete a file
                    if (file_exists($whole_image_path)) {
                        unlink($whole_image_path);
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
                            $query = mysqli_query($con, "UPDATE `infrastructuretypes` SET `name`='$type',`iconpath`='$db_targetPath' WHERE  `id` = $type_id ");

                            $data['success'] = true;
                            $data['message'] = 'Infrastructure Type Updated!';
                        } else {
                            $data['success'] = false;
                            $data['message'] = 'Infrastructure Type not Updated';
                        }
                    } else {
                        $formatedname = strip_tags($type);
                        $formatedname = str_replace(" ", "_", $formatedname);

                        $temp = explode(".", $_FILES["inputfile"]["name"]);

                        // setting image new file name
                        $postfix = '_' . date('YmdHis') . '_' . str_pad(rand(1, 10000), 5, '0', STR_PAD_LEFT);
                        $newfilename = stripslashes($formatedname . '_map_icon') . $postfix . '.' . end($temp);
                        $targetPath = $target_dir . basename($newfilename);
                        $db_targetPath = $db_target_dir . basename($newfilename);

                        if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $targetPath)) {
                            $query = mysqli_query($con, "UPDATE `infrastructuretypes` SET `name`='$type',`iconpath`='$db_targetPath' WHERE  `id` = $type_id ");

                            $data['success'] = true;
                            $data['message'] = 'Infrastructure Type Updated!';
                        } else {
                            $data['success'] = false;
                            $data['message'] = 'Infrastructure Type not Updated';
                        }
                    }
                } else {
                    $data['success'] = false;
                    $data['message'] = 'Infrastructure ImagePath Not Found';
                }

            }


        } else {

            $data['success'] = false;
            $data['message'] = 'Infrastructure Type not Updated';
        }
    } elseif ($action == 3) {

        //delete btn clicked

        if (isset($_POST['type_id'])) {

            $type_id = $_POST['type_id'];

            $type_sql = mysqli_query($con, "SELECT iconpath FROM infrastructuretypes  WHERE  `id` = $type_id LIMIT 1");
            $row = mysqli_fetch_array($type_sql);

            if ($row != null) {
                $mapIcon_image_path = $row['iconpath'];
                $whole_image_path = "../" . $mapIcon_image_path;

                // Use unlink() function to delete a file
                if (file_exists($whole_image_path)) {
                    unlink($whole_image_path);
                    $delete_type_sql = "DELETE FROM `infrastructuretypes` WHERE  `id` = $type_id";

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
                    $delete_type_sql = "DELETE FROM `infrastructuretypes` WHERE  `id` = $type_id";

                    mysqli_query($con, $delete_type_sql);

                    $affected_rows = mysqli_affected_rows($con);

                    if ($affected_rows >= 1) {
                        $data['success'] = true;
                        $data['message'] = $affected_rows . ' Infrastructure Deleted! ';
                    } else if ($affected_rows <= 0) {
                        $data['success'] = false;
                        $data['message'] = 'Infrastructure Type Not Deleted';
                    }
                }
            } else {
                $data['success'] = false;
                $data['message'] = 'Infrastructure Not Found';
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


//getting current page url
function pathUrl($dir = __DIR__)
{

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    //HTTPS or HTTP
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    //HOST
    $root .= '://' . $_SERVER['HTTP_HOST'];

    //ALIAS
    if (!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
    } else {
        $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
    }

    $root .= '/';

    return $root;
}
