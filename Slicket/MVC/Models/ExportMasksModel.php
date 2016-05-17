<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;
use DateTime as DateTime;

class ExportMasksModel extends BaseModel {
  private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function get_device_list() {
        $this->db->query("SELECT id,username FROM oauth_users;");
        $this->db->execute();
        
        return $this->db->resultSet();
    }
    
    public function search_patients($device, $start, $end) {
        $this->db->query("SELECT * FROM mask_finished_patients WHERE device_id = :pid AND str_to_date(date, '%d%m%y') >= str_to_date(:pstart, '%d%m%y') AND str_to_date(date, '%d%m%y') <= str_to_date(:pend, '%d%m%y') ORDER BY date,pat_order");
        $this->db->bind(":pid", $device);
        $this->db->bind(":pstart", $start);
        $this->db->bind(":pend", $end);
        $this->db->execute();
        
        return $this->db->resultSet();
    }
}