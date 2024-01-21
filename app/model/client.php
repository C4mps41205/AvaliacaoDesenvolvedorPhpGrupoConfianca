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

            $sqlSelect = "SELECT * FROM ". $this->table ." left join state on state.id = client_register.state ". $stringWhere;
            $query = $this->conn->query($sqlSelect);
            $fetch = $query->fetchAll();

            $mensage = array(
                "status" => 200,
                "response" => $fetch,
            );
        } catch (PDOException $exception) 
        {
            $mensage = array(
                "status" => 500,
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

    public function Update($data) : array
    {
        $mensage = array();
        try 
        {
            $sqlString = "UPDATE " . $this->table . " SET name = :name,
                                                        itr = :itr,
                                                        birthdate = :birthdate,
                                                        state = :state,
                                                        city = :city,
                                                        neighborhood = :neighborhood,
                                                        phone = :phone,
                                                        email = :email
                                                    WHERE idClient = :id";

            $query = $this->conn->prepare($sqlString);

            $query->bindParam(':name', $data['name']);
            $query->bindParam(':itr', $data['itr']);
            $query->bindParam(':birthdate', $data['birthdate']);
            $query->bindParam(':state', $data['state']);
            $query->bindParam(':city', $data['city']);
            $query->bindParam(':neighborhood', $data['neighborhood']);
            $query->bindParam(':phone', $data['phone']);
            $query->bindParam(':email', $data['email']);
            $query->bindParam(':id', $data['idClient']);

            if($query->execute())
            {
                $mensage = array(
                    "status" => 200,
                    "response" => "success"
                );
            }

        } catch (PDOException $exception) 
        {
            $mensage = array(
                "status" => 500,
                "response" => $exception->getMessage()
            );
        }

        return $mensage;
    }
}
?>