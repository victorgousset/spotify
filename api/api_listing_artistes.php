<?php
header('Access-Control-Allow-Origin: *');
require_once '../class_database/prepare_request.php';
require_once 'api_count_artistes.php';
//  $_get['ListingArtistes'] = ['3',10];

 function ListingAlbums(array $ListingArtistes)
 {
   $manager_request = new prepare_request();

   if (is_array($ListingArtistes) == false || (is_array($ListingArtistes) == true && count($ListingArtistes) < 2) || is_numeric($ListingArtistes[0]) == false || is_numeric($ListingArtistes[1]) == false)
         return ([false, (is_array($ListingArtistes) == true ? 'Required in array 2 value numeric' : 'You give a '. gettype($ListingArtistes).', you didn\'t give an array.')]);
   if (($length_artistes = api_count_artistes())[0] == false)
      return $length_artistes;

   $sql = "SELECT " . ((count($ListingArtistes) >= 3 && $ListingArtistes[2] == true) ? '* ': 'name ') ." FROM `artists` LIMIT ". ($ListingArtistes[0] < 0 ? 0 : $ListingArtistes[0]) . ',' . ($ListingArtistes[1] <= 0 ? $ListingArtistes[1] = $length_artistes[1] : $ListingArtistes[1]);
   $manager_request->prepare_request($sql); 
   $e = $manager_request->prepare_request->execute();
   return ($e == true ? [true, $manager_request->prepare_request->fetchAll()] : [false, 'An error occurred while contacting the server']);
 }

if (isset($_get['ListingArtistes']))
   echo json_encode( ListingAlbums($_get['ListingArtistes']));

// ListingALbums recuperer un array avec oubligatoirement 2 valeur numeric la premiere le nombre d'artiste a recuperer 1 ,10 , 20 ect..
//la 2 eme valeur dans le tableau doit etre defini et numeric  permet de recuperer les artiste via un index,
// example:
//  si le premier parametre a pour valeur 10 et le 2 eme 14 , on va recuperer les artiste 10 on prend les artise de 14 a 24;
// si le premiere valeur est une valeur negatif on la remplace par 0 est on commance du debut;
// si la 2 eme valeur est negatif ou 0 on va recuper tout les artiste;
// 3 eme parametre pas oubligatoire si besoin des info des artiste