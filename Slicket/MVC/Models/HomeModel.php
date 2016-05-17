<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;

class HomeModel extends BaseModel {
  private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function list_of_all_devices() {
      $this->db->query("SELECT * FROM oauth_users;");
      $this->db->execute();

      $rows = $this->db->resultSet();

      return $rows;
    }
    
    public function update_email_for_user($id, $email) {
        $this->db->query("UPDATE user SET email = :pmail WHERE id = :pid;");
        $this->db->bind(":pmail", $email);
        $this->db->bind(":pid", $id);
        $this->db->execute();
    }
    
    public function update_password_for_user($id, $password) {
        $this->db->query("UPDATE user SET password = :ppassword WHERE id = :pid;");
        $this->db->bind(":ppassword", md5($password));
        $this->db->bind(":pid", $id);
        $this->db->execute();
    }
    
    public function check_password($id, $password) {
        $this->db->query("SELECT password FROM user WHERE id = :pid;");
        $this->db->bind(":pid", $id);
        $this->db->execute();
        
        return ($this->db->single()["password"] == md5($password));
    }
}
