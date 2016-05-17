<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;
use DateTime as DateTime;

class FinishedMasksModel extends BaseModel {
  private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function get_device_list() {
        $this->db->query("SELECT id,username FROM oauth_users;");
        $this->db->execute();
        
        return $this->db->resultSet();
    }
    
    public function get_finished_weeks() {
        $this->db->query("SELECT tour_finished.*, oauth_users.username FROM tour_finished INNER JOIN oauth_users ON tour_finished.device_id = oauth_users.id ORDER BY tour_finished.week_nr DESC LIMIT 10;");
        $this->db->execute();
        $rows = $this->db->resultSet();

        return $rows;
    }
    
    public function get_patients_for_week($mask_id) 
    {
        $this->db->query("SELECT * FROM tour_finished_patients where tour_finished_id = :pid ORDER BY date, pat_nr, worker_token;");
        $this->db->bind(":pid", $mask_id);
        $this->db->execute();
        
        $rows = $this->db->resultSet();

        return $rows;
    }
    
    public function search_masks($group_id) {
        $this->db->query("SELECT * FROM tour_finished WHERE device_id = :pid ORDER BY id DESC;");
        $this->db->bind(":pid", $group_id);
        $this->db->execute();
        
        return $this->db->resultSet();
    }
    
    public function search_patients($mask_id) {
        $this->db->query("SELECT * FROM tour_finished_patients WHERE tour_finished_id = :pid;");
        $this->db->bind(":pid", $mask_id);
        $this->db->execute();
        
        $rows = $this->db->resultSet();
        
        foreach ($rows as $row) {
            $row["pat_arrival"] = substr($row["pat_arrival"], 0, 5);
            $row["pat_departure"] = substr($row["pat_departure"], 0, 5);
        }

        return $rows;
    }
}