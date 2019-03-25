<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function index()
    {
        $this->load->view("/template/head.php");

        $query = $this->db->query("SELECT * FROM egais_acts WHERE `replyid`=? and `fsrar`=?",array($data['replyid'],$data['fsrar']));
        $result = $query->result();
        var_dump($this->db);
        $this->load->view("/main/index.php",array("asds"=>'hi'));


        $this->load->view("/template/foot.php");
    }

    public function acts()
    {
        print(1);
    }
}
