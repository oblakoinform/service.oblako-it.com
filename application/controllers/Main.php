<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function index()
    {
        $this->load->view("/template/head.php");


        $this->load->view("/template/main/index.php");


        $this->load->view("/template/foot.php");
    }

    public function acts()
    {
        print(1);
    }
}
