<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {


    public function acts() {
        $this->load->view("/template/head.php",array("title"=>"Акты по алкоголю"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month =date("m");
        }

        $query = $this->db->query("SELECT * FROM `egais_producer`, `egais_acts` WHERE INN IN('1660287087','1660273045','1656102470','1650332125')  AND `egais_producer`.`ClientRegId`=`egais_acts`.`fsrar` AND MONTH(`egais_acts`.`dt`)=? AND `egais_acts`.`TypeWriteOff` NOT LIKE 'Иные цели' GROUP BY `egais_producer`.`ClientRegId` ORDER BY `egais_producer`.`INN` DESC",array($month));
        $result = $query->result();

        $query = $this->db->query("SELECT egais_acts.fsrar,egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE month(dt)=?) AND egais_acts.type IN('ActWriteOff_v3', 'ActWriteOffShop_v2') AND egais_product.ProductVCode NOT IN (500,510,520,261,262,263) GROUP BY egais_acts.fsrar,egais_acts_position.AlcCode;",array($month));
        $result2 = $query->result();
        $Aresult2=array();
        foreach ($result2 as $item){

            if (!isset($Aresult2[$item->fsrar])){
                $Aresult2[$item->fsrar]=array();
            }
            array_push($Aresult2[$item->fsrar],$item);
        }

        $Aresult3=array();
        $query = $this->db->query("SELECT egais_acts.fsrar,egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE month(dt)=?) AND egais_acts.type='ActChargeOnShop_v2' AND egais_product.ProductVCode NOT IN (500,510,520,261,262,263) GROUP BY egais_acts.fsrar,egais_acts_position.AlcCode;",array($month));
        $result3 = $query->result();
        foreach ($result3 as $item){
            if (!isset($Aresult3[$item->fsrar])){
                $Aresult3[$item->fsrar]=array();
            }
            array_push($Aresult3[$item->fsrar],$item);
        }


        $this->load->view("/main/acts.php",array("result"=>$result,"Aresult2"=>$Aresult2,"Aresult3"=>$Aresult3,"month"=>$month));


        $this->load->view("/template/foot.php");


    }



    public function acts_pivo() {
        $this->load->view("/template/head.php",array("title"=>"Акты по пиву"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month =date("m");
        }

        $query = $this->db->query("SELECT * FROM `egais_producer`, `egais_acts` WHERE `egais_producer`.`INN` IN('1660287087','1660273045','1656102470','1650332125')  AND `egais_producer`.`ClientRegId`=`egais_acts`.`fsrar` AND MONTH(`egais_acts`.`dt`)=? AND `egais_acts`.`TypeWriteOff` LIKE 'Иные цели' GROUP BY `egais_producer`.`ClientRegId` ORDER BY `egais_producer`.`INN` DESC",array($month));
        $result = $query->result();

        $query = $this->db->query("SELECT egais_acts.fsrar,egais_product.FullName, egais_acts_position.AlcCode, SUM(egais_acts_position.Quantity) as Quantity, egais_product.AlcVolume, egais_product.Capacity, egais_product.ProductVCode, egais_acts.type FROM egais_acts_position INNER JOIN egais_acts ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_acts_position.AlcCode = egais_product.AlcCode WHERE egais_Acts_id IN (SELECT id FROM egais_acts WHERE month(dt)=?) GROUP BY egais_acts.fsrar,egais_acts_position.AlcCode;",array($month));
        $result2 = $query->result();
        $Aresult2=array();
        foreach ($result2 as $item){

            if (!isset($Aresult2[$item->fsrar])){
                $Aresult2[$item->fsrar]=array();
            }
            array_push($Aresult2[$item->fsrar],$item);
        }


        $this->load->view("/main/acts_pivo.php",array("result"=>$result,"Aresult2"=>$Aresult2,"month"=>$month));


        $this->load->view("/template/foot.php");


    }



    public function test() {
        $this->load->view("/template/head.php",array("title"=>"Тест по пиву"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month =date("m");
        }

        $query = $this->db->query("SELECT * FROM `egais_producer` WHERE ClientRegId IN(SELECT DISTINCT fsrar FROM `egais_acts` WHERE MONTH(dt)=?) AND INN IN('1660287087','1660273045','1656102470','1650332125') ORDER BY `egais_producer`.`INN` DESC",array($month));       $producer = $query->result();

        $Aproducer = array();
        foreach($producer as $item) {
            $Aproducer[$item->ClientRegId] = $item;
        }

        $this->load->view("/main/test.php",array("Aproducer"=>$Aproducer,"month"=>$month));
        $this->load->view("/template/foot.php");

    }

    public function getdata() {

        $month = $_GET['month'];
        $ClientRegId = $_GET['ClientRegId'];

        $query = $this->db->query("SELECT AlcCode, sum(Quantity) FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE fsrar=? AND MONTH(dt)=? AND type IN('ActWriteOffShop_v2','ActWriteOff_v3')) GROUP BY AlcCode",array($ClientRegId,$month));
        $actWrite = $query->result();

        $query = $this->db->query("SELECT AlcCode, sum(Quantity) FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE fsrar=? AND MONTH(dt)=? AND type='ActChargeOnShop_v2') GROUP BY AlcCode",array($ClientRegId,$month));
        $actCharge = $query->result();


        $AlcCode = array();
        foreach($actWrite as $item3) {
            array_push($AlcCode,$item3->AlcCode);
        }


        foreach($actCharge as $item4) {
            array_push($AlcCode,$item4->AlcCode);
        }


        $query = $this->db->query("SELECT * FROM `egais_product` WHERE AlcCode IN ? AND ProductVCode IN(500,510,520,261,262,263)",array($AlcCode));
        $product = $query->result();

        $Aproduct = array();
        foreach($product as $item2) {
            $Aproduct[$item2->AlcCode] = $item2;
        }


        $this->load->view("/main/getdata.php",array("AactWrite"=>$AactWrite,"AactCharge"=>$AactCharge,"ClientRegId"=>$ClientRegId,"month"=>$month,"Aproduct"=>$Aproduct));


    }


    public function checks()  {

        print(1);
    }
}
