<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function index() {
        $this->load->view("/template/head.php",array("title"=>"Акты"));
        $this->load->view("/main/index.php");
        if(isset($_POST['fsrar']) && isset($_POST['month'])){
        $fsrar = $_POST['fsrar'];
        $month = $_POST['month'];
        $month2 = date("m");
        $month = $month2;
        }
        if(!empty($fsrar)&&($month2)){

            $query = $this->db->query("SELECT * FROM egais_acts_position INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE fsrar=? AND month(dt)=?)",array($fsrar,$month2));

            $result = $query->result();
            $this->load->view("/main/index.php",array("result"=>$result));
        }
        else{
            echo "Выберите месяц и вставьте в поле ФСРАР ИД";
        }
       $this->load->view("/template/foot.php");
    }

    public function acts()
    {
        print(1);
    }
}
