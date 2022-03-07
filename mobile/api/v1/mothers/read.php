<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../../../admin/config.php';
include_once '../Functions/MotherFunction.php';

$database = new Database();
$db = $database->getConnString();

$motherFunction = new MotherFunction($db);

$motherFunction->page = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : '0';

$result = $motherFunction->All_Infrastructure();

if($result){    
    http_response_code(200);     
    echo json_encode($result);
}else{     
    http_response_code(404);     
    echo json_encode(
        array("message" => "No item found.")
    );
} 
?>


