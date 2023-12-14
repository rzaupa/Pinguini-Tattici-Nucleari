<?php

require_once "DBAccess.php";

use DB\DBAccess;

$albumHTML = file_get_contents("album.html");

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

$album_title = "";

$album_string = "";

$album_id = $_GET["id"];

if ($connOk) {
    [$id, $album_title, $copertina, $dataPubblicazione, $durataAlbum] = $connessione->getAlbum($album_id);
    if ($album_title != null) {
        $album_string .= "<img src=\"$copertina\" id=\"albumCover\">"
            . "<dl id=\"albumInfor\"><dt>Durata: </dt><dd><time>" . $durataAlbum . "</time></dd>
          <dt>Data di uscita: </dt><dd><time datetime=" . $dataPubblicazione . '">' . date("j F Y", strtotime($dataPubblicazione)) . '</time></dd>';
    } else {
        $album_string = "<p>Album non esistente o id non corretto<p>";
    }
} else {
    $album_string = "<p>Non sono presenti album.</p>";
}

echo str_replace("{NomeAlbum}", $album_title, str_replace("{album}", $album_string, $albumHTML));

/*
{titoloAlbum}
{informazioni album}
*/