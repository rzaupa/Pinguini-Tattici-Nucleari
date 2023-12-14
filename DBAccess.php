<?php

namespace DB;

class DBAccess
{
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "rzaupa";
    private const USERNAME = "rzaupa";
    private const PASSWORD = "hohNgesha4ceeX7u";
    private $connection;
    public function openDBconnection()
    {
        $this->connection = mysqli_connect(
            self::HOST_DB,
            self::USERNAME,
            self::PASSWORD,
            self::DATABASE_NAME
        );
        return mysqli_connect_errno() == 0;
    }

    public function getListaAlbum()
    {
        $query = "SELECT ID, Titolo, Copertina, idCss FROM Album ORDER BY DataPubblicazione DESC"; //da fare
        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $result = array();
            while ($row = mysqli_fetch_array($queryResult)) {
                $result[] = $row;
            }
            $queryResult->free();
            return $result;
        } else {
            return null;
        }
    }

    public function getAlbum($id)
    {
        $query = "SELECT Album.ID, 
        Album.Titolo, 
        Album.Copertina, 
        Album.DataPubblicazione,
        SEC_TO_TIME(SUM(TIME_TO_SEC(Traccia.Durata))) as DurataAlbum 
        FROM Album
        LEFT JOIN Traccia ON Album.ID=Traccia.Album
        WHERE Album.ID=$id";
        echo $query;

        $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess" . mysqli_error($this->connection));
        if (mysqli_num_rows($queryResult) != 0) {
            $row = mysqli_fetch_assoc($queryResult);
            $queryResult->free();
            return array($row["ID"], $row["Titolo"], $row["Copertina"], $row["DataPubblicazione"], $row["DurataAlbum"]);
        } else {    
            return null;
        }
    }

    public function getTracceAlbum($id)
    {
        "SELECT Traccia.Titolo,
        Traccia.Esplicito,
        Traccia.Durata,
        Traccia.DataRadio,
        Traccia.URLVideo
    FROM Traccia
    JOIN Album ON Traccia.Album=Album.id
    WHERE Traccia.Album=$id";
    }

    public function insertNewTrack($album, $titolo, $durata, $esplicito, $dataRadio, $urlVideo, $note)
    {
        $queryInsert = "INSERT INTO Traccia(Titolo,Durata,Esplicito, URLVideo, DataRadio, Album, Note)
        VALUE (\"$titolo\",\"$durata\",\"$esplicito\",NULLIF(\"$urlVideo\",\"\"),NULLIF(\"$dataRadio\",\"\"),\"$album\",NULLIF(\"$note\",\"\"))";
        mysqli_query($this->connection, $queryInsert) or die(mysqli_error($this->connection));
        return mysqli_affected_rows($this->connection) > 0;
    }

    public function closeConnection()
    {
        mysqli_close($this->connection);
    }
}
