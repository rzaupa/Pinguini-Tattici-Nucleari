<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$aggiungiTracciaHTML = file_get_contents("aggiungiTraccia.html");

$messaggiPerForm = "";
$listaAlbum = "";
$albumStringa = "";

function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

if ($connOk) {
    $resultListaAlbum = $connessione->getListaAlbum();
    foreach ($resultListaAlbum as $album) {

        if (isset($_POST['submit']) && isset($_POST['album']) && isset($_POST['album']) == $album["ID"]) {
            $listaAlbum .= "<option value=\""
                . $album["ID"] . "\" selected>"
                . $album["Titolo"]
                . "</option>";
        } else {
            /* metodo alex
            ['ID' => $id, 'Titolo' => $titolo] = $album;
            $listaAlbum = "<option value=\"$id\">$titolo</option>";
            */
            $listaAlbum .= "<option value=\""
                . $album["ID"] . "\">"
                . $album["Titolo"]
                . "</option>";
        }
    }
}

if (isset($_POST['submit'])){
    
}

echo str_replace("{listaAlbum}", $listaAlbum, $aggiungiTracciaHTML);
echo str_replace("{messaggiForm}", $messaggiPerForm, $aggiungiTracciaHTML);
