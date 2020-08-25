<?php
header('Access-Control-Allow-Origin: *');
    require_once '../class_database/prepare_request.php';
    function gettrack($id)
    {
        if (is_numeric($id) == false)
            return [false,'need value numeric for search tracks by id'];
        $manager_request = new prepare_request();
        $manager_request->prepare_request("SELECT * FROM `tracks` where album_id = ?");

        if ($manager_request->prepare_request->execute([]) == false)
            return ([false, 'An error occurred while contacting the server']);
        else
            return ($manager_request->prepare_request->rowCount() >= 1 ? [true, $manager_request->prepare_request->fetchAll()] : [false, 'No element found']);
    }
if(isset($_POST['gettrack']))
{
    echo json_encode(gettrack($_POST['gettrack']));
}
