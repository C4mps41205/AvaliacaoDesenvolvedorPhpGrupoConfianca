<?php
include __DIR__.'/../model/client.php';
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
        include __DIR__.'/../view/home/index.php';
        return;
    }

    public function SelectClient() : void
    {

        echo json_encode($this->client->Select($_POST));
        return;
    }

    public function Delete() : void
    {
        echo json_encode($this->client->Delete($_POST));
        return;
    }
}
?>