<?php

require_once "connesione.php";

use DB\DBAccess;

//require_once ".." . DIRECTORY_SEPARATOR . "connessione.php";

$discografiaHTML = file_get_contents("albumTemplate.html");

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

$album_title = "";

$album_string = "";

$album_id = $_GET["id"];

if ($connOk) {
    [$album_title, $copertina, $dataPubblicazione, $durataAlbum] = $connection->getAlbum($album_id);
    if ($album_title != null) {
        $album_string .= "<img src=\"$copertina\" id=\"albumCover\"><dl id=\"albumInfor\"><dt>Durata</dt><dd>" . $durataAlbum .
            "</dd><dt>Data di uscita: </dt><dd><time datetime=\"$dataPubblicazione\">. 
            date(\"j F Y" . strtotime($dataPubblicazione) . "</time></dd>";
    }
} else {
    $album_string = "<p>Album non esistente o id non corretto<p>";
}

echo str_replace("{NomeAlbum}", $album_title, $discografiaHTML);
echo str_replace("{album}", $album_string, $discografiaHTML);

/*
{titoloAlbum}
{informazioni album}
*/