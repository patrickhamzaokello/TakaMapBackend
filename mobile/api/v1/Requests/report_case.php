<?php
//set headers to NOT cache a page
header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include_once '../../../../admin/config.php';
include_once '../Functions/PickupHandler.php';

$database = new Database();
$db = $database->getConnString();


$pickup_obj = new PickupHandler($db);
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->user_id) && !empty($data->full_name) &&
    !empty($data->phone_number) && !empty($data->address) && !empty($data->trash_description)){

    $pickup_obj->user_id = $data->user_id;
    $pickup_obj->full_name = $data->full_name;
    $pickup_obj->phone_number = $data->phone_number;
    $pickup_obj->address = $data->address;
    $pickup_obj->trash_description = $data->trash_description;


    if($pickup_obj->create()){
        http_response_code(201);
        $response['error'] = false;
        $response['message'] = 'Request Submitted.';
        echo json_encode($response);

    } else{
        http_response_code(503);
        $response['error'] = true;
        $response['message'] = 'Unable to Submit Request.';
        echo json_encode($response);
    }
}else{
    http_response_code(400);
    $response['error'] = true;
    $response['message'] = 'Unable to Submit Request. Data is incomplete.';
    echo json_encode($response);
}
?>