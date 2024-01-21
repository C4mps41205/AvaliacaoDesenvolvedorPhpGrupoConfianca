<?php

class State extends Database
{
    private string $table;

    public function __construct(DatabaseCredentials $databaseCredentials)
    {
        parent::__construct($databaseCredentials);
        $this->table = "state";
    }

    public function SelectAll() : array
    {
        $mensage = array();
        try 
        {
            $sqlSelect = "SELECT * FROM ". $this->table ;
            $query = $this->conn->query($sqlSelect);
            $fetch = $query->fetchAll();

            $mensage = array(
                "status" => 200,
                "response" => $fetch,
            );
        } catch (PDOException $exception) 
        {
            $mensage = array(
                "status" => 200,
                "response" => $exception->getMessage()
            );
        }

        return $mensage;
    }
}
?>