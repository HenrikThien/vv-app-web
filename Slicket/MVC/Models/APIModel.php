<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;
use OAuth2 as OAuth2;

class APIModel extends BaseModel {
	private $db = null;
	public $server;

    public function __construct($db) {
        $this->db = $db;

				OAuth2\Autoloader::register();

				$config = array(
				    'access_lifetime'                => 7*86400,    // 7 days
				    'refresh_token_lifetime'         => 6*31*86400, // 6 month
				    'always_issue_new_refresh_token' => true
				);

				$storage = new OAuth2\Storage\Pdo(array('dsn' => "mysql:dbname=".DB_NAME.";host=".DB_HOST."", 'username' => DB_USER, 'password' => DB_PASSWORD));
				$this->server = new OAuth2\Server($storage, $config);
    }

		public function verify_user($groupname, $password)
		{
				$this->db->query("SELECT id FROM oauth_users WHERE username = :puser AND password = :ppass LIMIT 1;");
				$this->db->bind(":puser", $groupname);
				$this->db->bind(":ppass", sha1($password));
				$this->db->execute();

				$count = $this->db->getRowCount();
				$response = array("valid" => false, "groupname" => "", "password" => "", "client_id" => "", "client_secret" => "");

				if ($count > 0) {
						$user_id = $this->db->single()["id"];

						if (!$this->checkIfClientExists($user_id)) {
								$this->db->query("INSERT INTO oauth_clients (client_id, client_secret, redirect_uri, user_id) VALUES (:pcid, :pcse, :puri, :pid);");
								$this->db->bind(":pcid", $groupname);
								$this->db->bind(":pcse", md5($groupname.$user_id));
								$this->db->bind(":puri", "http://app.visvitalis.info/callback");
								$this->db->bind(":pid", $user_id);
								$this->db->execute();
						}

						// create the json response
						$response["groupname"] = $groupname;
						$response["password"] = $password;
						$response["client_id"] = $groupname;
						$response["client_secret"] = md5($groupname.$user_id);
						$response["valid"] = true;
				}

				return $response;
		}

		public function register_device($groupname, $token) {
				$this->db->query("UPDATE oauth_users SET device_id = :pid WHERE username = :pname LIMIT 1;");
				$this->db->bind(":pid", $token);
				$this->db->bind(":pname", $groupname);
				$this->db->execute();

				$response = array("valid" => true, "message" => "Gerät wurde erfolgreich aktualisiert.");
				return $response;
		}

		private function checkIfClientExists($id)
		{
				$this->db->query("SELECT user_id FROM oauth_clients WHERE user_id = :pid LIMIT 1;");
				$this->db->bind(":pid", $id);
				$this->db->execute();

				return ($this->db->getRowCount() > 0);
		}
        
        public function tryupdate($id) {
            $registrationIds = array();

            $this->db->query("SELECT device_id FROM oauth_users WHERE id = :pid;");
            $this->db->bind(":pid", $id);
            $this->db->execute();

            $device_code = $this->db->single()["device_id"];
            array_push($registrationIds, $device_code);

            // prep the bundle
            $msg = array
            (
                'type' => 'update'
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
        
        public function create_json_mask_by_favo($groupname) {
            $mask = array("einsatz" => array("datum" => "", "ma" => "", "touren" => array(
				array("id" => "morgens", "patient" => array()),
				array("id" => "abends", "patient" => array())
			)));

			$patients = $this->get_patients_favo($groupname);

            $masknr = 0;
			foreach ($patients as $pat) {
				$arr_to_push = array("nr" => 0, "patient" => "", "km" => "", "ank" => "", "abf" => "", "mission" => "", "order" => "", "leistung" => array());

                $masknr = $pat["tour_mask_id"];
				$arr_to_push["nr"] = $pat["pat_nr"];
				$arr_to_push["patient"] = $pat["pat_firstname"] . " " . $pat["pat_lastname"];
				$arr_to_push["leistung"] = explode(",", $pat["pat_performances"]);
                $arr_to_push["order"] = $pat["pat_order"];

				if ($this->starts_with($pat["pat_mission"], "V")) {
                    $pat["pat_mission"] = (strlen($pat["pat_mission"]) > 1 ? substr($pat["pat_mission"], 1, strlen($pat["pat_mission"])) : $pat["pat_mission"]);
                    $arr_to_push["mission"] = $pat["pat_mission"];
					array_push($mask["einsatz"]["touren"][0]["patient"], $arr_to_push);
				}
				else if ($this->starts_with($pat["pat_mission"], "A")) {
                    $pat["pat_mission"] = (strlen($pat["pat_mission"]) > 1 ? substr($pat["pat_mission"], 1, strlen($pat["pat_mission"])) : $pat["pat_mission"]);
                    $arr_to_push["mission"] = $pat["pat_mission"];
					array_push($mask["einsatz"]["touren"][1]["patient"], $arr_to_push);
				}
			}

			return array("masknr" => $masknr, "mask" => $mask);
        }

		public function create_json_mask($groupname, $mask_nr) {
			$mask = array("einsatz" => array("datum" => "", "ma" => "", "touren" => array(
				array("id" => "morgens", "patient" => array()),
				array("id" => "abends", "patient" => array())
			)));

			$patients = $this->get_patients_for_mask($mask_nr);

			foreach ($patients as $pat)
			{
				$arr_to_push = array("nr" => 0, "patient" => "", "km" => "", "ank" => "", "abf" => "", "mission" => "", "order" => "", "leistung" => array());

				$arr_to_push["nr"] = $pat["pat_nr"];
				$arr_to_push["patient"] = $pat["pat_firstname"] . " " . $pat["pat_lastname"];
				$arr_to_push["leistung"] = explode(",", $pat["pat_performances"]);
                $arr_to_push["order"] = $pat["pat_order"];

				if ($this->starts_with($pat["pat_mission"], "V")) {
                    $pat["pat_mission"] = (strlen($pat["pat_mission"]) > 1 ? substr($pat["pat_mission"], 1, strlen($pat["pat_mission"])) : $pat["pat_mission"]);
                    $arr_to_push["mission"] = $pat["pat_mission"];
					array_push($mask["einsatz"]["touren"][0]["patient"], $arr_to_push);
				}
				else if ($this->starts_with($pat["pat_mission"], "A")) {
                    $pat["pat_mission"] = (strlen($pat["pat_mission"]) > 1 ? substr($pat["pat_mission"], 1, strlen($pat["pat_mission"])) : $pat["pat_mission"]);
                    $arr_to_push["mission"] = $pat["pat_mission"];
					array_push($mask["einsatz"]["touren"][1]["patient"], $arr_to_push);
				}
			}

			return $mask;
		}
        
        private function starts_with($string, $char) {
            return (strtolower(substr($string, 0, 1)) == strtolower($char));
        }

		private function get_patients_for_mask($mask_nr)
		{
			$this->db->query("SELECT * FROM tour_mask_patients WHERE tour_mask_id = :pid ORDER BY pat_order,id;");
			$this->db->bind(":pid", $mask_nr);
			$this->db->execute();

			return $this->db->resultSet();
		}
        
        private function get_patients_favo($groupname) {
            $this->db->query("SELECT id FROM oauth_users WHERE username = :pname LIMIT 1;");
            $this->db->bind(":pname", $groupname);
            $this->db->execute();
            $id = $this->db->single()["id"];
            
            $this->db->query("SELECT * FROM tour_masks WHERE device_id = :pid AND favo = '1' LIMIT 1;");
            $this->db->bind(":pid", $id);
            $this->db->execute();
            $count = $this->db->getRowCount();
            $mask = $this->db->single();
            
            $patients = array();
            
            if ($count > 0) {
                $this->db->query("SELECT * FROM tour_mask_patients WHERE tour_mask_id = :pid ORDER BY pat_order,id;");
                $this->db->bind(":pid", $mask["id"]);
                $this->db->execute();
                $patients = $this->db->resultSet();
            }
            
            return $patients;
        }
        
        public function get_device_id_by_name($name) {
            $this->db->query("SELECT id FROM oauth_users WHERE username = :pname LIMIT 1;");
            $this->db->bind(":pname", $name);
            $this->db->execute();
            $id = $this->db->single()["id"];
            return $id;
        }
		
        public function save_finished_patients_mask_new($json_string) {
            $mask_data = json_decode($json_string, true); 
            
            foreach ($mask_data["patients"] as $patient_obj) {
                $groupname = $patient_obj["groupname"];
                $date = $patient_obj["date"];
                $device_id = $this->get_device_id_by_name($groupname);
                $patient = $patient_obj["patient"];
                
                $this->db->query("INSERT INTO mask_finished_patients (device_id, pat_nr, pat_firstname, pat_lastname, pat_mission, pat_performances, pat_arrival, pat_departure, pat_km, worker_token, date, pat_order) VALUES (:pdevice_id, :ppat_nr, :ppat_firstname, :ppat_lastname, :ppat_mission, :ppat_performances, :ppat_arrival, :ppat_departure, :ppat_km, :pworker_token, :pdate, :porder);");
                
                $this->db->bind(":pdevice_id", $device_id);
                $this->db->bind(":ppat_nr", $patient["nr"]);
                $this->db->bind(":ppat_firstname", (strlen($patient["patient"]) > 0 && strpos($patient["patient"], ' ') ? explode(" ", $patient["patient"])[0] : $patient["patient"]));
                $this->db->bind(":ppat_lastname", (strlen($patient["patient"]) > 0 && strpos($patient["patient"], ' ') ? explode(" ", $patient["patient"])[1] : $patient["patient"]));
                $this->db->bind(":ppat_mission", (strlen($patient["mission"]) > 0) ? $patient["mission"] : "xxx");
                $this->db->bind(":ppat_performances", implode(",", $patient["leistung"]));
                $this->db->bind(":ppat_arrival", (strlen($patient["ank"]) > 0) ? $patient["ank"] : "00:01");
                $this->db->bind(":ppat_departure", (strlen($patient["abf"]) > 0) ? $patient["abf"] : "00:02");
                $this->db->bind(":ppat_km", (isset($patient["km"]) && strlen($patient["km"]) > 0) ? $patient["km"] : 0);
                $this->db->bind(":pworker_token", $patient["ma"]);
                $this->db->bind(":pdate", $date); // FUU
                $this->db->bind(":porder", (strlen($patient["order"]) > 0) ? $patient["order"] : 0);
                $this->db->execute();
            }   
        }
        
		public function save_finished_patients_mask($json_string)
		{
			$mask_data = json_decode($json_string, true);
			
			$groupname = $mask_data["groupname"];
			$week_nr = $mask_data["weeknr"];
			$mask_nr = $mask_data["masknr"];
			$mask_date_start = $mask_data["datum_start"];
            $mask_date_end = $mask_data["datum_end"];
            
            $this->db->query("SELECT id FROM oauth_users WHERE username = :pusername;");
            $this->db->bind(":pusername", $groupname);
            $this->db->execute();
            $group_id = $this->db->single()["id"];
            
            $this->db->query("INSERT INTO tour_finished (mask_id, week_nr, device_id, worker_token, date, datum_start, datum_end) VALUES (:pmaskid, :pweeknr, :pdeviceid, :pworkertoken, :pdate, :pdstart, :pdend);");
            $this->db->bind(":pmaskid", $mask_nr);
            $this->db->bind(":pweeknr", $week_nr);
            $this->db->bind(":pdeviceid", $group_id);
            $this->db->bind(":pworkertoken", "xxx");
            $this->db->bind(":pdate", "xxx");
            $this->db->bind(":pdstart", $mask_date_start);
            $this->db->bind(":pdend", $mask_date_end);
            $this->db->execute();
            $theId = $this->db->getLastInsertId();
            
            foreach ($mask_data["data"] as $types) {
                $masktypes = $types["einsatz"];
                $mask_date = $masktypes["datum"];
                $mask_worker_token = $masktypes["ma"]; // nicht mehr interessant..
                $mask_tours = $masktypes["touren"];

                foreach ($mask_tours as $tour) {
                    $tour_type_patients = $tour["patient"];               
                    foreach ($tour_type_patients as $patient) {
                        $this->db->query("INSERT INTO tour_finished_patients (tour_finished_id, pat_nr, pat_firstname, pat_lastname, pat_mission, pat_performances, pat_arrival, pat_departure, pat_km, worker_token, date, pat_order) VALUES (:ptour_finished_id, :ppat_nr, :ppat_firstname, :ppat_lastname, :ppat_mission, :ppat_performances, :ppat_arrival, :ppat_departure, :ppat_km, :pworker_token, :pdate, :porder);");
                        $this->db->bind(":ptour_finished_id", $theId);
                        $this->db->bind(":ppat_nr", $patient["nr"]);
                        $this->db->bind(":ppat_firstname", explode(" ", $patient["patient"])[0]);
                        $this->db->bind(":ppat_lastname", explode(" ", $patient["patient"])[1]);
                        $this->db->bind(":ppat_mission", $patient["mission"]);
                        $this->db->bind(":ppat_performances", implode(",", $patient["leistung"]));
                        $this->db->bind(":ppat_arrival", $patient["ank"]);
                        $this->db->bind(":ppat_departure", $patient["abf"]);
                        $this->db->bind(":ppat_km", $patient["km"]);
                        $this->db->bind(":pworker_token", $patient["ma"]);
                        $this->db->bind(":pdate", $mask_date);
                        $this->db->bind(":porder", $patient["order"]);
                        $this->db->execute();
                    }
                }
            }
		}
}
