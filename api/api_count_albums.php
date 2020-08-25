<?php
header('Access-Control-Allow-Origin: *');
require_once '../class_database/prepare_request.php';
function api_count__albums()
{
    $manager_request = new prepare_request();
    $manager_request->prepare_request('SELECT COUNT(*) FROM `albums`');
    return ($manager_request->prepare_request->execute() == true ? [true, $manager_request->prepare_request->fetch()[0]] : [false, 'An error occurred while contacting the server']);
}
if (isset($_get['get_number_albums']))
{
   echo json_encode (api_count__albums());
}