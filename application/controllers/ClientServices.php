<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientServices extends CI_Controller {


    public function index()
    {
        
    }

    public function sendcheck()
    {
        $jsonresult=array();
        if ( isset($_FILES["xml_file"]) && isset($_POST['globalid'])) {
            $xml = file_get_contents($_FILES["xml_file"]["tmp_name"]);

            $jsondata = json_decode($xml);
            $data = (array)$jsondata;
            $globalid=$data['globalid'];
            foreach ($data['checks'] as $check){
                $check=(array)$check;
                $this->db->query('INSERT INTO `kassa_check` (`globalid`, `Identity`, `dt_open`, `dt_close`, `alc_url`, `alc_sign`, `mode`, `smena`, `dt_sync`, `fiscalstatus`, `kassir_fio`, `fsrar`, `inn`, `kpp`, `fullname`, `shortname`, `address`) VALUES (?,?,?,?,?,?,?,?,NOW(),?,?,?,?,?,?,?,?)', array($globalid,$check["Identity"],$check["dt_open"],$check["dt_close"],$check["alc_url"]  ,$check["alc_sign"],$check["mode"],$check["smena"],$check["fiscalstatus"],$check["kassir_fio"],$check["fsrar"],$check["inn"],$check["kpp"],$check["fullname"],$check["address"],$check["shortname"]));
                $check_id = $this->db->insert_id();
                foreach ($check['check_position'] as $check_position){
                    $check_position=(array)$check_position;
                    $check_position["Capacity"]=isset($check_position["Capacity"])?$check_position["Capacity"]:0;
                    $check_position["AlcCode"]=isset($check_position["AlcCode"])?$check_position["AlcCode"]:'';
                    $check_position["AlcVolume"]=isset($check_position["AlcVolume"])?$check_position["AlcVolume"]:0;
                    $check_position["ProductVCode"]=isset($check_position["ProductVCode"])?$check_position["ProductVCode"]:0;
                    $check_position["UnitType"]=isset($check_position["UnitType"])?$check_position["UnitType"]:'';

                    $this->db->query('INSERT INTO `kassa_check_positions` (`pos`, `quantity`, `price`, `fullname`, `typ_id`, `edizm_id`, `shtrih`, `marka`, `kassa_check_id`, `beersend`, `backalc`, `back`, `alc`, `ismarka`, `Capacity`, `AlcCode`, `AlcVolume`, `ProductVCode`, `UnitType`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($check_position["pos"],$check_position["quantity"],$check_position["price"],$check_position["fullname"],$check_position["typ_id"],$check_position["edizm_id"],$check_position["shtrih"],$check_position["marka"],$check_id,$check_position["beersend"],$check_position["backalc"],$check_position["back"],$check_position["alc"],$check_position["ismarka"],$check_position["Capacity"],$check_position["AlcCode"],$check_position["AlcVolume"],$check_position["ProductVCode"],$check_position["UnitType"]));
                }
            }
            $jsonresult['globalid']=$globalid;
        }
        $this->load->view("/clientService/returnJSONresult.php", array("result" => $jsonresult));
    }
    public function sendact()
    {
        $jsonresult=array();
        if ( isset($_FILES["xml_file"]) && isset($_POST['fsrar'])) {
            $xml = file_get_contents($_FILES["xml_file"]["tmp_name"]);
            $jsondata= json_decode($xml);
            $data=(array)$jsondata;
            $query = $this->db->query("SELECT * FROM egais_acts WHERE `replyid`=? and `fsrar`=?",array($data['replyid'],$data['fsrar']));
            $result = $query->result();
            if (count($result)==0) {
                $this->db->query('INSERT INTO egais_acts(fsrar,dt,status,replyid,`type`,param,TypeWriteOff,Note) VALUES(?,NOW(),?,?,?,?,?,?)', array($data['fsrar'], '0', $data['replyid'], $data['type'], $data['param'], $data['TypeWriteOff'], $data['Note']));
                $act_id = $this->db->insert_id();
                $data['act_id'] = $act_id;
                foreach ($data['position'] as $index => $item2) {
                    $item = (array)$item2;

                    if (!isset($item['Inform2RegId'])) {
                        $item['Inform2RegId'] = '';
                    }
                    $this->db->query('INSERT INTO egais_acts_position(Inform2RegId,AlcCode,Quantity,egais_Acts_id) VALUES(?,?,?,?)', array($item['Inform2RegId'], $item['AlcCode'], $item['Quantity'], $data['act_id']));
                    $egais_Acts_position_id = $this->db->insert_id();
                    if (isset($item['amc'])) {
                        foreach ($item['amc'] as $indexamc => $itemamc2) {
                            $itemamc = (array)$itemamc2;
                            $this->db->query('INSERT INTO egais_acts_position_amc(amc,egais_Acts_position_id) VALUES(?,?)', array($itemamc, $egais_Acts_position_id));
                        }
                    }

                }

            }
            $jsonresult['replyid']=$data['replyid'];
        }
        $this->load->view("/clientService/returnJSONresult.php", array("result" => $jsonresult));

    }


}
