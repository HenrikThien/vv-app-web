<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;

class CreateMaskModel extends BaseModel {
  private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save_patient_for_week($mask_id, $group_id, $pat_nr, $pat_firstname, $pat_lastname, $pat_mission, $pat_performances)
    {
      $response = array("valid" => false, "message" => "", "pat_data" =>
                  array("id" => -1, "masknr" => $mask_id, "pat_nr" => $pat_nr, "pat_firstname" => $pat_firstname, "pat_lastname" => $pat_lastname, "pat_mission" => $pat_mission, "pat_performances" => $pat_performances));

      if ($mask_id > 0)
      {
        $orderpos = ($this->get_max_order_pos($mask_id)) + 1;

        $this->db->query("INSERT INTO tour_mask_patients (tour_mask_id, pat_nr, pat_firstname, pat_lastname, pat_mission, pat_performances, pat_order) VALUES (:maskid, :patnr, :patfirstname, :patlastname, :patmission, :patperformances, :patorder);");
        $this->db->bind(":maskid", $mask_id);
        $this->db->bind(":patnr", $pat_nr);
        $this->db->bind(":patfirstname", $pat_firstname);
        $this->db->bind(":patlastname", $pat_lastname);
        $this->db->bind(":patmission", $pat_mission);
        $this->db->bind(":patperformances", $pat_performances);
        $this->db->bind(":patorder", $orderpos);
        $this->db->execute();

        $response["pat_data"]["id"] = $this->db->getLastInsertId();

        $response["pat_data"]["masknr"] = $mask_id;
        $response["valid"] = true;
        $response["message"] = "Der Datensatz wurde erfolgreich hinzugef&uuml;gt.";
      }
      else
      {
        $response["valid"] = false;
        $response["message"] = "Es ist ein Fehler beim hinzuf&uuml;gen aufgetreten.";
      }

      return $response;
    }

    public function get_max_order_pos($mask_id) {
      $this->db->query("SELECT MAX(tm.pat_order) as max_order FROM tour_mask_patients tm WHERE tm.tour_mask_id = :pid;");
      $this->db->bind(":pid", $mask_id);
      $this->db->execute();

      return $this->db->single()["max_order"];
    }

    public function copy_mask($mask_id, $new_group, $current_group) {
        $patients = $this->get_masks_patients_by_id($mask_id, $current_group);

        $new_mask_id = $this->create_new_mask($new_group);
        foreach ($patients as $patient) {
            $this->save_patient_for_week($new_mask_id, $new_group, $patient["pat_nr"], $patient["pat_firstname"], $patient["pat_lastname"], $patient["pat_mission"], $patient["pat_performances"]);
        }
    }

    public function get_old_masks_for_group($group_id) {
        $this->db->query("SELECT tm.id, tm.favo, COUNT(tmp.pat_nr) as pcount FROM tour_masks tm LEFT JOIN tour_mask_patients tmp ON tm.id = tmp.tour_mask_id WHERE tm.device_id = :did GROUP BY tm.id ORDER BY tm.id;");
        $this->db->bind(":did", $group_id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function set_favorite_mask($mask_id, $group_id, $type) {
        $this->db->query("UPDATE tour_masks SET favo = '0' WHERE device_id = :pgroup;UPDATE tour_masks SET favo = :ptype WHERE id = :pid AND device_id = :pgroup;");
        $this->db->bind(":pid", $mask_id);
        $this->db->bind(":pgroup", $group_id);
        $this->db->bind(":ptype", $type);
        $this->db->execute();
    }

    public function create_new_mask($group_id) {
        $this->db->query("INSERT INTO tour_masks (week_nr, device_id) VALUES (:pweek, :pgroup);");
        $this->db->bind(":pweek", date("W"));
        $this->db->bind(":pgroup", $group_id);
        $this->db->execute();

        return $this->db->getLastInsertId();
    }

    public function get_masks_patients_by_id($id, $group_id) {
        $this->db->query("SELECT tmp.* FROM tour_mask_patients tmp INNER JOIN tour_masks tm ON tmp.tour_mask_id = tm.id WHERE tm.id = :pid AND tm.device_id = :pgroup ORDER BY tmp.pat_order,tmp.id;");
        $this->db->bind(":pgroup", $group_id);
        $this->db->bind(":pid", $id);
        $this->db->execute();

        return $this->db->resultSet();
    }

    public function change_table_order($mask_id, $order_data) {
        $query = "";

        foreach ($order_data as $key => $value) {
            $patient = htmlspecialchars($value["patient"]);
            $order = htmlspecialchars($value["order"]);

            $query .= "UPDATE tour_mask_patients SET pat_order = " . $order . " WHERE id = " . $patient . " AND tour_mask_id = :pmaskid;";
        }

        $this->db->query($query);
        $this->db->bind(":pmaskid", $mask_id);
        $this->db->execute();
    }

    public function delete_mask($id, $group_id) {
        $this->db->query("DELETE FROM tour_masks WHERE id = :pid AND device_id = :pgroup;");
        $this->db->bind(":pid", $id);
        $this->db->bind(":pgroup", $group_id);
        $this->db->execute();

        $this->db->query("DELETE FROM tour_mask_patients WHERE tour_mask_id = :pid;");
        $this->db->bind(":pid", $id);
        $this->db->execute();
    }

    public function get_masks_patients_for_week()
    {
      $week_nr = date("W");

      $this->db->query("SELECT tour_mask_patients.*, tour_masks.id FROM tour_mask_patients INNER JOIN tour_masks ON tour_mask_patients.tour_mask_id = tour_masks.id WHERE tour_masks.week_nr = :pweeknr AND tour_masks.device_id = 0;");
      $this->db->bind(":pweeknr", $week_nr);
      $this->db->execute();

      return $this->db->resultSet();
    }

    public function delete_patient($pat_nr, $mask_nr, $theid, $pat_mis)
    {
      $this->db->query("DELETE FROM tour_mask_patients WHERE id = :pid AND pat_mission = :pmis AND pat_nr = :patnr AND tour_mask_id = :masknr;");
      $this->db->bind(":pid", $theid);
      $this->db->bind(":pmis", $pat_mis);
      $this->db->bind(":patnr", $pat_nr);
      $this->db->bind(":masknr", $mask_nr);
      $this->db->execute();
    }

    public function get_all_devices()
    {
      $this->db->query("SELECT * FROM oauth_users");
      $this->db->execute();

      return $this->db->resultSet();
    }

    public function send_notification_to_device($device_id, $mask_id)
    {
      $registrationIds = array();

      $this->db->query("SELECT device_id FROM oauth_users WHERE id = :pid;");
      $this->db->bind(":pid", $device_id);
      $this->db->execute();

      $device_code = $this->db->single()["device_id"];
      array_push($registrationIds, $device_code);

      // prep the bundle
      $msg = array
      (
        'type' => 'download',
        'masknr' => $mask_id,
        'weeknr' => date("W"),
        'year' => date("Y"),
        'just_add' => 'false'
      );

      $fields = array
      (
      	'registration_ids' 	=> $registrationIds,
      	'data'			    => $msg
      );

      $headers = array
      (
      	'Authorization: key=' . API_ACCESS_KEY,
      	'Content-Type: application/json'
      );

      $ch = curl_init();
      curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
      curl_setopt( $ch,CURLOPT_POST, true );
      curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
      curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
      $result = curl_exec($ch );
      curl_close( $ch );
      return $result;
    }

    public function set_groupname_for_mask($mask_nr, $group_id)
    {
      $this->db->query("UPDATE tour_masks SET device_id = :pdeviceid WHERE id = :pid;");
      $this->db->bind(":pdeviceid", $group_id);
      $this->db->bind(":pid", $mask_nr);
      $this->db->execute();
    }
}
