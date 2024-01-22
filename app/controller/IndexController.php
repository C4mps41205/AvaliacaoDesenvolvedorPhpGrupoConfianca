<?php
class IndexController 
{
    private DatabaseCredentials $databaseCredentials;
    private Client $client;
    public function __construct()
    {
        $this->databaseCredentials = new DatabaseCredentials();
        $this->client = new Client($this->databaseCredentials);
    }

    public function Index() : void
    {
        $state = new State($this->databaseCredentials);
        $allState = $state->SelectAll();
        include __DIR__.'/../view/home/index.php';
        return;
    }

    public function SelectClient() : void
    {
        if(!isset($_POST) or count($_POST) === 0)
        {
            echo json_encode(array(
                "status" => 500,
                "mensage" => "data doesn't came with success"
            ));
            return;
        }

        echo json_encode($this->client->Select($_POST));
        return;
    }

    public function Delete($id) : void
    {
        if(!isset($id) || !(isset($_POST["delete"])))
        {
            echo json_encode(array(
                "status" => 500,
                "mensage" => "data doesn't came with success"
            ));
            return;
        }

        echo json_encode($this->client->Delete($id[0]));
        return;
    }

    public function Update() : void
    {
        if(count($_POST) === 0 or !isset($_POST["idClient"]))
        {
            echo json_encode(array(
                "status" => 500,
                "mensage" => "data doesn't came with success"
            ));
            return;   
        }

        echo json_encode($this->client->Update($_POST));
        return;
    }

    public function Create() : void
    {
        if(count($_POST) === 0)
        {
            echo json_encode(array(
                "status" => 500,
                "mensage" => "data doesn't came with success"
            ));
            return;
        }

        if(!isset($_POST["name"]) or !isset($_POST["itr"]) or !isset($_POST["birthdate"]))
        {
            echo json_encode(array(
                "status" => 500,
                "mensage" => "data doesn't came with success"
            ));
            return;
        }

        echo json_encode($this->client->Insert($_POST));
        return;
    }
}
?>