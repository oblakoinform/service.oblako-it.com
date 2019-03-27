<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function index()
    {
        $this->load->view("/template/head.php",array("title"=>"акты"));
        $fsrar = $_POST['fsrar'];
        $month = $_POST['month'];
        if(isset($fsrar) && isset($month)){

            $query = $this->db->query("SELECT * FROM egais_acts_position INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE fsrar=? AND MONTH (dt)=?)",array($fsrar,$month));
            $result = $query->result();
            $this->load->view("/main/index.php",array("result"=>$result));

        }

        $this->load->view("/template/foot.php");
    }

    public function acts()
    {
        print(1);
    }
}
