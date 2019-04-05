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
        $query = $this->db->query("SELECT AlcCode FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE MONTH(dt)=?) GROUP BY AlcCode",array($month));
        $result = $query->result();
        $AlcCode = array();
        foreach($result as $item) {
            array_push($AlcCode,$item->AlcCode);
        }
        $query = $this->db->query("SELECT AlcCode FROM egais_product where ProductVCode not  in (263, 520, 500, 510, 262, 261) and AlcCode in ?",array($AlcCode));
        $result = $query->result();
        $pivoAlcCode = array();
        foreach($result as $item) {
            array_push($pivoAlcCode ,$item->AlcCode);
        }

        $query = $this->db->query("SELECT * FROM `egais_producer` WHERE INN IN('1660287087','1660273045','1656102470','1650332125')  and ClientRegId IN(SELECT DISTINCT fsrar FROM `egais_acts` WHERE MONTH(dt)=? and id in (SELECT egais_acts_id FROM egais_acts_position where AlcCode in ?)) ORDER BY INN DESC",array($month,$pivoAlcCode ));
        $producer = $query->result();

        $Aproducer = array();
        foreach($producer as $item) {
            $Aproducer[$item->ClientRegId] = $item;
        }

        $this->load->view("/main/acts.php",array("Aproducer"=>$Aproducer,"month"=>$month));
        $this->load->view("/template/foot.php");

    }



    public function acts_pivo() {
        $this->load->view("/template/head.php",array("title"=>"Акты по пиву"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month =date("m");
        }
        $query = $this->db->query("SELECT AlcCode FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE MONTH(dt)=?) GROUP BY AlcCode",array($month));
        $result = $query->result();
        $AlcCode = array();
        foreach($result as $item) {
            array_push($AlcCode,$item->AlcCode);
        }
        $query = $this->db->query("SELECT AlcCode FROM egais_product where ProductVCode in (263, 520, 500, 510, 262, 261) and AlcCode in ?",array($AlcCode));
        $result = $query->result();
        $pivoAlcCode = array();
        foreach($result as $item) {
            array_push($pivoAlcCode ,$item->AlcCode);
        }

        $query = $this->db->query("SELECT * FROM `egais_producer` WHERE INN IN('1660287087','1660273045','1656102470','1650332125')  and ClientRegId IN(SELECT DISTINCT fsrar FROM `egais_acts` WHERE MONTH(dt)=? and id in (SELECT egais_acts_id FROM egais_acts_position where AlcCode in ?)) ORDER BY INN DESC",array($month,$pivoAlcCode ));
        $producer = $query->result();

        $Aproducer = array();
        foreach($producer as $item) {
            $Aproducer[$item->ClientRegId] = $item;
        }

        $this->load->view("/main/acts_pivo.php",array("Aproducer"=>$Aproducer,"month"=>$month));
        $this->load->view("/template/foot.php");

    }



    public function test() {
        $this->load->view("/template/head.php",array("title"=>"Тест по пиву"));

        if(isset($_POST['month'])){
            $month = $_POST['month'];

        } else {
            $month =date("m");
        }
        $query = $this->db->query("SELECT AlcCode FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE MONTH(dt)=?) GROUP BY AlcCode",array($month));
        $result = $query->result();
        $AlcCode = array();
        foreach($result as $item) {
            array_push($AlcCode,$item->AlcCode);
        }
        $query = $this->db->query("SELECT AlcCode FROM egais_product where ProductVCode not  in (263, 520, 500, 510, 262, 261) and AlcCode in ?",array($AlcCode));
        $result = $query->result();
        $pivoAlcCode = array();
        foreach($result as $item) {
            array_push($pivoAlcCode ,$item->AlcCode);
        }

        $query = $this->db->query("SELECT * FROM `egais_producer` WHERE INN IN('1660287087','1660273045','1656102470','1650332125')  and ClientRegId IN(SELECT DISTINCT fsrar FROM `egais_acts` WHERE MONTH(dt)=? and id in (SELECT egais_acts_id FROM egais_acts_position where AlcCode in ?))",array($month,$pivoAlcCode ));
        $producer = $query->result();

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

        $query = $this->db->query("SELECT AlcCode, sum(Quantity) as Quantity FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE fsrar=? AND MONTH(dt)=? AND type IN('ActWriteOffShop_v2','ActWriteOff_v3')) GROUP BY AlcCode",array($ClientRegId,$month));
        $actWrite = $query->result();

        $query = $this->db->query("SELECT AlcCode, sum(Quantity) as Quantity FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE fsrar=? AND MONTH(dt)=? AND type='ActChargeOnShop_v2') GROUP BY AlcCode",array($ClientRegId,$month));
        $actCharge = $query->result();


        $AlcCode = array();
        foreach($actWrite as $item3) {
            array_push($AlcCode,$item3->AlcCode);
        }


        foreach($actCharge as $item4) {
            array_push($AlcCode,$item4->AlcCode);
        }


        $query = $this->db->query("SELECT * FROM `egais_product` WHERE AlcCode IN ?",array($AlcCode));
        $product = $query->result();

        $Aproduct = array();
        foreach($product as $item2) {
            $Aproduct[$item2->AlcCode] = $item2;
        }

        $this->load->view("/main/getdata.php",array("actWrite"=>$actWrite,"actCharge"=>$actCharge,"ClientRegId"=>$ClientRegId,"month"=>$month,"Aproduct"=>$Aproduct));


    }


    public function checks()  {

        print(1);
    }
}
