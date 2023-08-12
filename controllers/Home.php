<?php
class Home extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $this->views->View('principal', 'login');
    }
}

?>