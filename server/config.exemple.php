<?php
class Database
{
    private $host = "localhost";
    private $username = "...";
    private $password = "...";
    private $dbname = "...";

    public function getConnection()
    {
        $connection = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($connection->connect_error) {
            die("Connexion échouée : " . $connection->connect_error);
        }
        return $connection;
    }
}

?>