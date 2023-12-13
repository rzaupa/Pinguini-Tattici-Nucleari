<?php

use DB\DBAccess;

require_once ".." . DIRECTORY_SEPARATOR . "connessione.php";

$discografiaHTML = file_get_contents("discografia.html");

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

$album_array = "";

$album_string = "";

if ($connOk) {
    $album_array = $connessione->getListaAlbum();
    $connessione->closeConnection();

    if ($album_array == null) {
        $album_string .= '<li id="album">';
    }

    foreach ($album_array as $album) {
        $album_string .= '<li>'. $album['Titolo'] .'</li>';
    }
}

echo str_replace('{album}',$album_string,$discografiaHTML);

$discografiaHTML = file_get_contents("discografia.html");

echo str_replace("{album}","gaggi infame",$discografiaHTML);

?>
