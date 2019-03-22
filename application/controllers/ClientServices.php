<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientServices extends CI_Controller {


    public function index()
    {
        
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
