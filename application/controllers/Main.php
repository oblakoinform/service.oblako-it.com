<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {



    public function totalCapacity(){

        if (isset($_POST['month'])) {
            $month = $_POST['month'];
        } else {
            $month = date("m");
        }
        if (isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = date("Y");
        }
        if (isset($_GET['excel'])){
            $excel=1;
            $month=$_GET['month'];
            $year=$_GET['year'];
        } else {
            $excel=0;
        }
        if ($excel==0) {
            $this->load->view("/template/head.php", array("title" => "Общий объем продаж и списаний"));
        }
        $dt1=$year."-".$month."-01";
        $dt2=$year."-".$month."-31";

        $Afsrar=array();
        $query = $this->db->query("SELECT ROUND(SUM(egais_acts_position.Quantity*egais_product.Capacity),3) as TotalCapacity,egais_acts.fsrar FROM `egais_acts` INNER JOIN egais_acts_position ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_product.AlcCode=egais_acts_position.AlcCode WHERE  egais_acts.dt>=? and egais_acts.dt<=? and egais_product.ProductVCode not  in (263, 520, 500, 510, 262, 261) and egais_acts.type IN('ActWriteOffShop_v2','ActWriteOff_v3') GROUP BY egais_acts.fsrar", array($dt1,$dt2));
        $acts1 = $query->result();
        $Aacts1=array();
        foreach ($acts1  as $act) {
            array_push($Afsrar, $act->fsrar);
            $Aacts1[$act->fsrar]=$act;
        }
        $query = $this->db->query("SELECT ROUND(SUM(egais_acts_position.Quantity*egais_product.Capacity),3) as TotalCapacity,egais_acts.fsrar FROM `egais_acts` INNER JOIN egais_acts_position ON egais_acts_position.egais_Acts_id=egais_acts.id INNER JOIN egais_product ON egais_product.AlcCode=egais_acts_position.AlcCode WHERE  egais_acts.dt>=? and egais_acts.dt<=? and egais_product.ProductVCode not  in (263, 520, 500, 510, 262, 261) and egais_acts.type NOT IN('ActWriteOffShop_v2','ActWriteOff_v3') GROUP BY egais_acts.fsrar", array($dt1,$dt2));
        $acts2 = $query->result();
        $Aacts2=array();
        foreach ($acts2  as $act) {
            array_push($Afsrar, $act->fsrar);
            $Aacts2[$act->fsrar]=$act;
        }

        $query = $this->db->query('SELECT FSRAR, ROUND(SUM(Capacity),3) AS TotalCapacity FROM `kassa_check_positions` INNER JOIN kassa_check ON kassa_check_positions.kassa_check_id=kassa_check.id WHERE backalc=0 and kassa_check.dt_close>=? AND kassa_check.dt_close<=? AND  kassa_check_positions.ismarka=1 GROUP BY FSRAR', array($dt1,$dt2));
        $checks = $query->result();

        $Achecks=array();
        foreach ($checks as $check){
            array_push($Afsrar,$check->FSRAR);
            $Achecks[$check->FSRAR]=$check;
        }
        unset($checks);
        unset($acts1);
        unset($acts2);


        $query = $this->db->query("SELECT AlcCode FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE MONTH(dt)=?) GROUP BY AlcCode", array($month));
        $result = $query->result();

        $Aproducer = array();
        if (count($Afsrar)) {
            $query = $this->db->query("SELECT * FROM `egais_producer` WHERE INN IN('1660287087','1660273045','1656102470','1650332125')  and ClientRegId IN ? order by INN DESC ", array($Afsrar));
            $producer = $query->result();
            foreach ($producer as $item) {
                $Aproducer[$item->ClientRegId] = $item;
            }
        }
        unset($producer);
        unset($Afsrar);
        if ($excel==1){
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-type:   application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=".$month.$year.".xsl");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
        }
        $this->load->view("/main/totalcapatity.php",array("month"=>$month,"year"=>$year,"checks"=>$Achecks,"Aproducer"=>$Aproducer,"Aacts1"=>$Aacts1,"Aacts2"=>$Aacts2,"excel"=>$excel));
        if ($excel==0) {
            $this->load->view("/template/foot.php");
        }
    }

    public function acts()
    {
        $this->load->view("/template/head.php", array("title" => "Акты по алкоголю"));

        if (isset($_POST['month'])) {
            $month = $_POST['month'];

        } else {
            $month = date("m");
        }
        $query = $this->db->query("SELECT AlcCode FROM `egais_acts_position` WHERE egais_Acts_id IN(SELECT id FROM egais_acts WHERE MONTH(dt)=?) GROUP BY AlcCode", array($month));
        $result = $query->result();
        $AlcCode = array();
        foreach ($result as $item) {
            array_push($AlcCode, $item->AlcCode);
        }
        $query = $this->db->query("SELECT AlcCode FROM egais_product where ProductVCode not  in (263, 520, 500, 510, 262, 261) and AlcCode in ?", array($AlcCode));
        $result = $query->result();
        $pivoAlcCode = array();
        foreach ($result as $item) {
            array_push($pivoAlcCode, $item->AlcCode);
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
        if (isset($_GET['showpivo'])) {
            $showpivo = $_GET['showpivo'];
        } else {
            $showpivo =null;
        }

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


        $query = $this->db->query("SELECT egais_product.AlcCode,egais_product.Capacity,egais_product.AlcVolume,egais_product.FullName,egais_product.ProductVCode,egais_producer.INN,egais_producer.KPP,egais_producer.FullName as producerFullName FROM `egais_product` INNER JOIN egais_producer ON egais_producer.ClientRegId=egais_product.ClientRegId  WHERE AlcCode IN ?",array($AlcCode));
        $product = $query->result();

        $Aproduct = array();
        foreach($product as $item2) {
            $Aproduct[$item2->AlcCode] = $item2;
        }

        $this->load->view("/main/getdata.php",array("showpivo"=>$showpivo,"actWrite"=>$actWrite,"actCharge"=>$actCharge,"ClientRegId"=>$ClientRegId,"month"=>$month,"Aproduct"=>$Aproduct));


    }


    public function checks()  {

        print(1);
    }
}
