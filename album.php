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
    $tracce_album = $connessione->getTracceAlbum($album_id);
    $connessione->closeConnection();
    if ($album_title != null) {
        $album_string .= "<img src=\"$copertina\" id=\"albumCover\">"
            . "<dl id=\"albumInfor\"><dt>Durata: </dt><dd><time>" . $durataAlbum . "</time></dd>"
            . "<dt>Data di uscita: </dt><dd><time datetime=" . $dataPubblicazione . '">' . date("j F Y", strtotime($dataPubblicazione)) . '</time></dd>';
        if ($tracce_album != null) {
            $album_string .= '<dt lang="en">Tracklist: </dt><dd><dl id="tracklist"><dd>';
            foreach ($tracce_album as $traccia) {
                $album_string .= $traccia["ID"] . "- </dd><dt>"
                    . $traccia["Titolo"] . "</dt><dd>"
                    . $traccia["Durata"] . "</dd>"
                    . "</dl>";
            }
        }
        $album_string .= "</dl>";
    } else {
        $album_string = "<p>Album non esistente o id non corretto<p>";
    }
} else {
    $album_string = "<p>Non sono presenti album.</p>";
}

echo str_replace("{NomeAlbum}", $album_title, str_replace("{album}", $album_string, $albumHTML));