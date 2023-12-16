<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$aggiungiTracciaHTML = file_get_contents("aggiungiTraccia.html");

$connessione = new DBAccess();

$connOk = $connessione->openDBConnection();

$messaggiPerForm = "";
$listaAlbum = "";
$album = "";
$titolo = "";
$durata = "";
$esplicito = "";
$dataRadio = "";
$urlVideo = "";
$note = "";

function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

if ($connOk) {
    $resultListaAlbum = $connessione->getListaAlbum();
    foreach ($resultListaAlbum as $AlbumLista) {

        if (isset($_POST['submit']) && isset($_POST['album']) && isset($_POST['album']) == $AlbumLista["ID"]) {
            $listaAlbum .= "<option value=\""
                . $AlbumLista["ID"] . "\" selected>"
                . $AlbumLista["Titolo"]
                . "</option>";
        } else {
            /* metodo alex
            ['ID' => $id, 'Titolo' => $titolo] = $album;
            $listaAlbum = "<option value=\"$id\">$titolo</option>";
            */
            $listaAlbum .= "<option value=\""
                . $AlbumLista["ID"] . "\">"
                . $AlbumLista["Titolo"]
                . "</option>";
        }
    }
    if (isset($_POST['submit'])) {
        $errore = false;
        $messaggiPerForm .= "<ul>";
        //album
        $album = pulisciInput($_POST["album"]);
        if ($album == "" || $album <= 0 || !filter_var($album, FILTER_VALIDATE_INT)) {
            $messaggiPerForm .= '<li class="errori">' . "Deve essere selezionato un album valido" . '</li>';
            $errore = true;
        }
        //titolo
        $titolo = pulisciInput($_POST["titolo"]);
        if (strlen($titolo) <= 2) {
            $messaggiPerForm .= '<li class="errori">' . "Il titolo deve essere presente ed essere formato da almeno 3 caratteri" . "</li>";
            $errore = true;
        }
        //durata
        $durata = pulisciInput($_POST["durata"]);
        if (strlen($durata) == 0) {
            $messaggiPerForm .= '<li class="errori">' . "La traccia deve avere una durata maggiore di 0" . "</li>";
            $errore = true;
        }
        //Contenuto esplicito
        $esplicito = pulisciInput($_POST["esplicito"]);
        if (($esplicito != "Yes") && ($esplicito != "No")) {
            $messaggiPerForm .= '<li class="errori">' . "Devi indicare se la traccia è esplcita o meno" . "</li>";
            $errore = true;
        }
        //dataRadio
        $dataRadio = pulisciInput($_POST["dataRadio"]);
        //url
        $urlVideo = pulisciInput($_POST["urlVideo"]);
        if (strlen($urlVideo) && !filter_var($urlVideo, FILTER_VALIDATE_URL)) {
            $messaggiPerForm .= '<li class="errori">' . "L'url non è stato inserito o non è valido" . "</li>";
            $errore=true;
        }
        //note
        $note = pulisciInput($_POST["note"]);
        //inserimento
        if (!$errore) {
            $traccia_inserita = $connessione->insertNewTrack($album, $titolo, $durata, $esplicito, $dataRadio, $urlVideo, $note);
            if ($traccia_inserita) {
                $messaggiPerForm .= '<li class="ok">' . "Traccia aggiunta correttamente" . '</li>';
            }
        }
        $messaggiPerForm .= "</ul>";
        /* esercizio sbagliato da alex
        [
            'album' => $id,
            'titolo' => $titolo,
            'durata' => $durata,
            'esplicito' => $esplicito,
            'dataRadio' => $dataRadio,
            'urlVideo' => $urlVideo,
            'note' => $note
        ] = $_POST;
        $connessione->insertNewTrack($id, $titolo, $durata, $esplicito, $dataRadio, $urlVideo, $note);
        */
    }
}


$connessione->closeConnection();

$aggiungiTracciaHTML = str_replace("{messaggiForm}", $messaggiPerForm, $aggiungiTracciaHTML);
$aggiungiTracciaHTML = str_replace("{listaAlbum}", $listaAlbum, $aggiungiTracciaHTML);
$aggiungiTracciaHTML = str_replace("{valoreTitolo}", $titolo, $aggiungiTracciaHTML);
$aggiungiTracciaHTML = str_replace("{valoreDurata}", $durata, $aggiungiTracciaHTML);
if($esplicito=="Yes"){
    $aggiungiTracciaHTML = str_replace("{checkedYes}", "checked", $aggiungiTracciaHTML);
    $aggiungiTracciaHTML = str_replace("{checkedNo}", "", $aggiungiTracciaHTML);
}
elseif($esplicito== "No"){
    $aggiungiTracciaHTML = str_replace("{checkedNo}", "checked", $aggiungiTracciaHTML);    
    $aggiungiTracciaHTML = str_replace("{checkedYes}", "", $aggiungiTracciaHTML);
}
$aggiungiTracciaHTML = str_replace("{valoreData}", $dataRadio, $aggiungiTracciaHTML);
$aggiungiTracciaHTML = str_replace("{valoreUrlVideo}", $urlVideo, $aggiungiTracciaHTML);
$aggiungiTracciaHTML = str_replace("{valoreNote}", $note, $aggiungiTracciaHTML);

echo $aggiungiTracciaHTML;
