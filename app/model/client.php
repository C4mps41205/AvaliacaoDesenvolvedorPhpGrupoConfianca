<?php
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
        $message = array();
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
                        $stringWhere .= $column === "name" ? " " . $column . " like '%" . $value . "%' AND" : " " . $column . " = '". $value . "' AND";
                    }
                }
            }

            $stringWhere = rtrim($stringWhere, " AND");
            $stringWhere = rtrim($stringWhere, " WHERE ");

            $sqlSelect = "SELECT * FROM ". $this->table ." left join state on state.id = client_register.state ". $stringWhere;
            $query = $this->conn->query($sqlSelect);
            $fetch = $query->fetchAll();

            $message = array(
                "status" => 200,
                "response" => $fetch
            );
        } catch (PDOException $exception) 
        {
            $message = array(
                "status" => 500,
                "response" => $exception->getMessage()
            );
        }

        return $message;
    }

    public function Delete($id = null) : array
    {
        $message = array();

        try
        {
            $sqlSelect = "DELETE FROM ". $this->table ." WHERE idClient = ". $id;
            $query = $this->conn->query($sqlSelect);

            if($query)
            {
                $message = array(
                    "status" => 200,
                    "response" => "success",
                );
            }

        } catch (PDOException $exception) 
        {
            $message = array(
                "status" => 500,
                "response" => $exception->getMessage()
            );
        }

        return $message;
    }

    public function Update($data) : array
    {
        $message = array();
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
                $message = array(
                    "status" => 200,
                    "response" => "success"
                );
            }

        } catch (PDOException $exception) 
        {
            $message = array(
                "status" => 500,
                "response" => $exception->getMessage()
            );
        }

        return $message;
    }

    public function Insert($data) : array
    {
        $message = array();
        try 
        {
            $sqlString = "INSERT INTO " . $this->table . " (name, itr, birthdate, state, city, neighborhood, phone, email) VALUES (:name, :itr, :birthdate, :state, :city, :neighborhood, :phone, :email)";

            $query = $this->conn->prepare($sqlString);
            
            $query->bindValue(':name', isset($data['name']) ? $data['name'] : NULL);
            $query->bindValue(':itr', isset($data['itr']) ? $data['itr'] : NULL);
            $query->bindValue(':birthdate', isset($data['birthdate']) ? $data['birthdate'] : NULL);
            $query->bindValue(':state', isset($data['state']) ? $data['state'] : null); 
            $query->bindValue(':city', isset($data['city']) ? $data['city'] : NULL);
            $query->bindValue(':neighborhood', isset($data['neighborhood']) ? $data['neighborhood'] : NULL);
            $query->bindValue(':phone', isset($data['phone']) ? $data['phone'] : NULL);
            $query->bindValue(':email', isset($data['email']) ? $data['email'] : NULL);
            
            if ($query->execute())
            {
                $message = array(
                    "status" => 200,
                    "response" => "success"
                );
            }
        

        } catch (PDOException $exception) 
        {
            $message = array(
                "status" => 500,
                "response" => $exception->getMessage(),
            );
        }

        return $message;
    }
}
?>