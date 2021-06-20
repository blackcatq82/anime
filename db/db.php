<?php

#
#   THIS SCRIPT FOR ANIME 
#   ^_^"
#   * we needed to upgrade always.
#
# POWERD BY BLACKCAT 2021 - 2022

class db
{
    private $connection;

    function __construct()
    {
        $this->connection = new mysqli('localhost','root','','cartoon3rbi');
    }
    public function Connect()
    {
        $this->connection = new mysqli('localhost','root','','cartoon3rbi');
        // Check connection
        if ($this->connection->connect_error) { die("فشل في الاتصال بالقاعدة: " . $conn->connect_error);}

        return $this->connection;
    }
    public function Close()
    {
        mysqli_close($this->connection);
		$this->connection = null;
        return $this->connection;
    }
    public function Disponse()
    {
        $this->connection = null;
        return  $this->connection;
    }
}
?>