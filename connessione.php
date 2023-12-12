<?php

namespace DB;

class DBAccess
{
    private const HOST_DB = "127.0.0.1";
    private const DATABASE_NAME = "abressan";
    private const USERNAME = "abressan";
    private const PASSWORD = "xoj7og9Ahgh0quah";

    private $connection;

    public function openDBconnection()
    {
        $this->connection = mysqli_connect(
            self::HOST_DB,
            self::DATABASE_NAME,
            self::USERNAME,
            self::PASSWORD,
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

    public function closeConnection()
    {
        mysqli_close($this->connection);
    }
}
