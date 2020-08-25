<?php
header('Access-Control-Allow-Origin: *');

 require_once '../class_database/prepare_request.php';

 $manager_request = new prepare_request();
 $manager_request->prepare_request('SELECT * FROM `genres`');
if ($manager_request->prepare_request->execute() == false)
    echo json_encode([false, 'An error occurred while contacting the server']);
else
  echo json_encode($manager_request->prepare_request->fetchAll());