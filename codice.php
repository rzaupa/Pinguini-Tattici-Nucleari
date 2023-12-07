<?php
    namespace DB
    class DBAccess {
        private const: HOST_DB = "localhost";
        private const: DATABASE_NAME="";
        private const: USERNAME="";
        private const: PASSWORD="";
        private $connection;

        public function openDBconnection(){
            $this->connection = mysqli_connect(
                self::HOST_DB,
                self::USERNAME,
                self::PASSWORD,
                self::DATABASE_NAME
            );
            return mysqli_connect_errno() = 0;
        }

        public function getListaAlbum(){
            $query = "SELECT ID, Titolo, Copertina, idCss FROM Album ORDER BY DataPubblicazione DESC"; //da fare
            $queryResult = mysqli_query($this->connection, $query) or die("Errore in DBAccess".mysqli_error($this->connection));
            if(mysqli_num_rows($queryResult) != 0) {
                $result = array();
                while($row = mysqli_fetch_array($queryResult)) {
                    $result[] = $row;
                }
                $queryResult->free();
                return $result;
            }else
            {
                return null;
            }
        }

        public function closeConnection(){
            mysqli_close($this->connection);
        }
    }
?>