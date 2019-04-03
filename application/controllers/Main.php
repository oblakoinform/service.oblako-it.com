<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function acts() {
        $this->load->view("/template/head.php",array("title"=>"Акты"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month ="";
        }
        if(!empty($month)){
            $query = $this->db->query("SELECT * FROM `egais_producer`, `egais_acts` WHERE INN IN('1660287087','1660273045','1656102470','1650332125') AND `egais_producer`.`ClientRegId`=`egais_acts`.`fsrar` AND MONTH(`egais_acts`.`dt`)=? GROUP BY `egais_producer`.`ClientRegId`;",array($month));
            $result = $query->result();
        } else {
            $result=array();
        }



        if(!empty($item->ClientRegId)&&($month)){
            $query = $this->db->query("SELECT egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE month(dt)=?) AND egais_acts.type IN('ActWriteOff_v3', 'ActWriteOffShop_v2') GROUP BY egais_acts_position.AlcCode ORDER BY `egais_acts`.`dt` ASC",array($month));
            $result2 = $query->result();
        } else {
            $result2=array();
        }

        if(!empty($item->ClientRegId)&&($month)){
            $query = $this->db->query("SELECT egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE month(dt)=?) AND egais_acts.type='ActChargeOnShop_v2' GROUP BY egais_acts_position.AlcCode ORDER BY `egais_acts`.`dt` ASC",array($month));
            $result3 = $query->result();
        } else {
            $result3=array();
        }


        $this->load->view("/main/acts.php",array("result"=>$result,"result2"=>$result2,"result3"=>$result3,"month"=>$month));


        $this->load->view("/template/foot.php");


    }





    public function acts_view() {

        $this->load->view("/template/head.php",array("title"=>"Акты"));

        if(isset($_POST['fsrar']) && isset($_POST['month'])){
            $fsrar = $_POST['fsrar'];
            $month = $_POST['month'];

        } else {
            $fsrar ="";
            $month ="";
        }
        if(!empty($fsrar)&&($month)){
            $query = $this->db->query("SELECT * FROM `egais_producer` WHERE ClientRegId=?;",array($fsrar));
            $result = $query->result();
        } else {
            $result=array();
        }

        if(!empty($fsrar)&&($month)){
            $query = $this->db->query("SELECT egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE fsrar=? AND month(dt)=?) AND egais_acts.type IN('ActWriteOff_v3','ActWriteOffShop_v2') GROUP BY egais_acts_position.AlcCode ORDER BY `egais_acts`.`dt` ASC",array($fsrar,$month));
            $result2 = $query->result();
        } else {
            $result2=array();
        }

        if(!empty($fsrar)&&($month)){
            $query = $this->db->query("SELECT egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE fsrar=? AND month(dt)=?) AND egais_acts.type='ActChargeOnShop_v2' GROUP BY egais_acts_position.AlcCode ORDER BY `egais_acts`.`dt` ASC",array($fsrar,$month));
            $result4 = $query->result();
          } else {
            $result4=array();
        }

        $this->load->view("/main/acts_view.php",array("result"=>$result,"result2"=>$result2,"result4"=>$result4,"month"=>$month,"fsrar"=>$fsrar));


       $this->load->view("/template/foot.php");
    }

    public function checks_view()
    {
        print(1);
    }
}
