<?php
/*
require_once "DBAccess.php";

use DB\DBAccess;

//require_once ".." . DIRECTORY_SEPARATOR . "connessione.php";

$discografiaHTML = file_get_contents("discografia.html");

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

$album_array = "";

$album_string = "";

if ($connOk) {
    $album_array = $connessione->getListaAlbum();
    $connessione->closeConnection();

    if ($album_array == null) {
        $album_string .= '<p>non sono presenti album<p></dl>';
    }

    foreach ($album_array as $album) {
        $album_string .= '<li><a id=\"' 
        . $album['idCss'] .
        "\" href=\"album.php? id="
        .$album["ID"]
        ."\">".$album["Titolo"]."</a></li>";
    }
}
else{
    $album_string="<p>i sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio<p>";
}

echo str_replace("{album}", $album_string, $discografiaHTML);
*/
$discografiaHTML = file_get_contents("discografia.html");
echo str_replace("{album}", "gaggi infame", $discografiaHTML);
