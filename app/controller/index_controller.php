<?php
include __DIR__.'/../model/client.php';
class IndexController 
{
    private DatabaseCredentials $databaseCredentials;
    public function __construct()
    {
        $this->databaseCredentials = new DatabaseCredentials();
    }

    public function Index() : void
    {
        include __DIR__.'/../view/home/index.php';
        return;
    }

    public function SelectClient() : void
    {
        $client = new Client($this->databaseCredentials);

        echo json_encode($client->Select($_POST));
        return;
    }
}
?>