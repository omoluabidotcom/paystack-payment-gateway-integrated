<?php

class dbconnect{

    private $host = 'localhost';
    private $user = 'root';
    private $dbname = 'dbb_paystackIntegration';
    private $pword = '';

    public function connector() {

        $dsn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pword);
        $dsn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $dsn;
    }
}

?>