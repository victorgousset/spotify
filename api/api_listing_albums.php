<?php
header('Access-Control-Allow-Origin: *');
require_once '../class_database/prepare_request.php';
require_once 'api_count_albums.php';
//  $_GET['ListingAlbums'] = '{"0":"0","1":"2","2":true,"3":["genre_id","10222"]}';

 function ListingAlbums(array $ListingAlbums)
 {
    $manager_request = new prepare_request();

    if (is_array($ListingAlbums) == false || (is_array($ListingAlbums) == true && count($ListingAlbums) < 2) || is_numeric($ListingAlbums[0]) == false || is_numeric($ListingAlbums[1]) == false)
            return ([false, (is_array($ListingAlbums) == true ? 'Required in array 2 value numeric' : 'You give a '. gettype($ListingAlbums).', you didn\'t give an array.')]);
    if (($length_artistes = api_count__albums())[0] == false)
        return $length_artistes;
      
    $limit = "  LIMIT ". ($ListingAlbums[0] < 0 ? 0 : $ListingAlbums[0]) . ',' . ($ListingAlbums[1] <= 0 ? $ListingAlbums[1] = $length_artistes[1] : $ListingAlbums[1]);
    $join = " t.* FROM (SELECT albums.*, artists.name as `name_artist` , genres.id as 'genre_id' , genres.name as 'genre_name' FROM albums JOIN genres_albums ON albums.id = genres_albums.album_id JOIN genres ON genres_albums.genre_id = genres.id JOIN artists on albums.artist_id = artists.id) as t ";
    $sql = "SELECT " . ((count($ListingAlbums) >= 3 && $ListingAlbums[2] == true) ? " $join " : 'name FROM albums ');
    $manager_request->prepare_request($sql, ($e = ((count($ListingAlbums) >= 4 && ($ListingAlbums[3][0] == 'genre_name' ||  $ListingAlbums[3][0] == 'genre_id')) ?  [$ListingAlbums[3]] : null)), $limit); 
 
    if($manager_request->prepare_request->execute((is_array($e) == true ? [$e[0][1]] : null)) == false)
        return  [false, 'An error occurred while contacting the server'];
    return ($manager_request->prepare_request->rowCount() >= 1 ? [true, $manager_request->prepare_request->fetchAll()] : [false, 'No element found']);
 }

 
if (isset($_GET['ListingAlbums']))
   echo json_encode(ListingAlbums(array_values(get_object_vars(json_decode(($_GET['ListingAlbums'])))))); 
