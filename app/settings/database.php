<?php

class Database
{
    protected PDO $conn;
    protected DatabaseCredentials $model;

    public function __construct(DatabaseCredentials $databaseCredentials)
    {
        $this->model = $this->SetCredentials($databaseCredentials);
        $this->CreateDb();
    }

    public function SetCredentials(DatabaseCredentials $model): DatabaseCredentials
    {
        $model  ->setHost($_SERVER['REMOTE_ADDR'])
                ->setDatabaseName('grupo-confianca-db')
                ->setUsername("root")
                ->setPassword("root-grupo-confianca");
        
        return $model;
    }

    public function CreateDb() : bool
    { 
        try 
        {
            $host = $this->model->getHost();
            $databaseName = $this->model->getDatabaseName();
            $username = $this->model->getUsername();
            $password = $this->model->getPassword();

            $this->conn = new PDO("mysql:host=".$host.";dbname=".$databaseName, $username, $password);
            
            if(!$this->conn)
            {
                echo "Algo deu errado na hora de se conectar ao banco de dados.";
                return false;
            }

            return true;
        } catch (Exception $exception) 
        {
            return false;
        }
    }
}
?>