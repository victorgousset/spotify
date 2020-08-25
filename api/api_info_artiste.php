<?php
header('Access-Control-Allow-Origin: *');
require_once '../class_database/prepare_request.php';
// $_GET['InfoArtiste'] = ['name', []];

function InfoArtiste(array $info)
{
    $manager_request = new prepare_request();

    if (is_array($info)  == false || (is_array($info)  == true && count($info) < 2))
    {
        return ([false, (is_array($info) == true ? 'Required in array with 2 value' : 'You give a '. gettype($info).', you didn\'t give an array.')]);
    }
    else if ($info[0] != 'name' && $info[0] != 'id')
        return ([false, 'selector unknown, select by id or name']);
    else if ($info[0] != 'name' && $info[0] == 'id' && is_numeric($info[1]) == false)
        return ([false, 'For select artiste by id, the value 2  is required to be a value numeric']);
    else if ($info[0] != 'id' && $info[0] == 'name' && is_string($info[1]) == false)
        return ([false, 'For select artiste by name, the value 2  is required to be a value string']);

    $manager_request->prepare_request("SELECT * FROM `artists`", [$info]);
    if(($e = $manager_request->prepare_request->execute([$info[1]])) == true)
        $val = $manager_request->prepare_request->fetch();
    else
        return [false, 'An error occurred while contacting the server'];
    return ($val != false ? [true, $val] : [false, 'no artist found']);
}
 
if (isset($_GET['InfoArtiste']))
{
    echo json_encode(InfoArtiste(array_values(get_object_vars(json_decode($_GET['InfoArtiste'])))));
}

// InfoArtiste(array $value);

// InfoArtiste prend en paramètre un tableau avec 2 valeur
// la premier valeur doit etre le selector name ou id
// la 2 eme valeur doit forcement etre une string ou un nombre pour l'id;

// valeur de retour
// un array [true, array_info_artiste]
// array [false, 'le message d'error'];