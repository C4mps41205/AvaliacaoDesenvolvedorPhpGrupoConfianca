<?php
include __DIR__.'/../model/client.php';
include __DIR__.'/../model/state.php';
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
            header('Location: /');
            return;
        }

        echo json_encode($this->client->Select($_POST));
        return;
    }

    public function Delete() : void
    {
        if(!isset($_POST['idClient']))
        {
            header('Location: /');
            return;
        }

        echo json_encode($this->client->Delete($_POST));
        return;
    }

    public function Update() : void
    {
        if(count($_POST) === 0 or !isset($_POST["idClient"]))
        {
            header('Location: /');
            return;   
        }

        echo json_encode($this->client->Update($_POST));
        return;
    }
}
?>