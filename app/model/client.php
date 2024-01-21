<?php
include __DIR__.'/../settings/database.php';

class Client extends Database
{
    private string $table;

    public function __construct(DatabaseCredentials $databaseCredentials)
    {
        parent::__construct($databaseCredentials);
        $this->table = "client_register";
    }

    public function Select($where = null) : array
    {
        $mensage = array();
        $stringWhere = " WHERE ";
        try 
        {
            if($where == "null")
            {
                $stringWhere = "";
            }   
            else
            {
                foreach($where as $column => $value)
                {
                    if(isset($value) and !empty($value))
                    {
                        $stringWhere .= " " . $column . " = '". $value . "' AND";
                    }
                }
            }

            $stringWhere = rtrim($stringWhere, " AND");
            $stringWhere = rtrim($stringWhere, " WHERE ");

            $sqlSelect = "SELECT * FROM ". $this->table ." ". $stringWhere;
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

    public function Delete($id = null) : array
    {
        $mensage = array();

        try
        {
            $sqlSelect = "DELETE FROM ". $this->table ." WHERE id = ". $id['id'];
            $query = $this->conn->query($sqlSelect);

            if($query)
            {
                $mensage = array(
                    "status" => 200,
                    "response" => "success",
                );
            }

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