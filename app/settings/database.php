<?php
include __DIR__.'/../model/database_credentials.php';

class Database
{
    protected $conn;
    protected $model;

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

    public function CreateDb() : PDO
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
                throw new Exception("Algo deu errado na hora de se conectar ao banco de dados.");
                die();
            }

            return $this->conn;
        } catch (Exception $exception) 
        {
            echo $exception->getMessage();
        }
    }
}
?>