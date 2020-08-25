<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require_once '../class_database/prepare_request.php';
$_POST['InfoAlbum_by_id_name'] = ['artist_id', '10'];

function InfoAlbum_by_id_name(array $info)
{
    $manager_request = new prepare_request();

    if (is_array($info)  == false || (is_array($info)  == true && count($info) < 2))
    {
        return ([false, (is_array($info) == true ? 'Required in array with 2 value' : 'You give a '. gettype($info).', you didn\'t give an array.')]);
    }
    else if ($info[0] != 'name_artist' && $info[0] != 'artist_id')
        return ([false, 'selector unknown, select by artist_id or name_artist']);
    else if ($info[0] != 'name_artist' && $info[0] == 'artist_id' && is_numeric($info[1]) == false)
        return ([false, 'For select artiste by artist_id, the value 2  is required to be a value numeric']);
    else if ($info[0] != 'artist_id' && $info[0] == 'name_artist' && is_string($info[1]) == false)
        return ([false, 'For select artiste by name, the value 2  is required to be a value string']);
    
    $sql = "SELECT albums.*,  artists.name as `name_artist` ,  genres.name as 'genre_name',  genres.id as 'genre_id' FROM albums JOIN genres_albums ON albums.id = genres_albums.album_id JOIN genres  ON genres_albums.genre_id = genres.id JOIN artists on albums.artist_id = artists.id";
    $manager_request->prepare_request($sql, [$info]);
    if(($e = $manager_request->prepare_request->execute([$info[1]])) == true)
        $val = $manager_request->prepare_request->fetch();
    else
        return [false, 'An error occurred while contacting the server'];
    return ($val != false ? [true, $val] : [false, 'no artist found']);
}

if (isset($_POST['InfoAlbum_by_id_name']))
{
    echo json_encode(InfoAlbum_by_id_name($_POST['InfoAlbum_by_id_name']));
}
 

//SELECT albums.*,  genres.name as 'genre_name',  genres.id as 'genre_id' FROM albums JOIN genres_albums     ON albums.id = genres_albums.album_id JOIN genres  ON genres_albums.genre_id = genres.id