<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;

class LoginModel extends BaseModel {
    protected $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isLoginValid($email, $password) {
      $this->db->query("SELECT id FROM user WHERE email = :pmail AND password = :ppassword LIMIT 1;");
      $this->db->bind("pmail", $email);
      $this->db->bind("ppassword", md5($password));
      $this->db->execute();

      $id = $this->db->single()["id"];
      $count = ($this->db->getRowCount() >= 1) ? true : false;

      return array("valid" => $count, "id" => $id);
    }

    public function createSession($user_id) {
      $this->db->query("SELECT user.*, rights.rank_name,rights.scope FROM user INNER JOIN rights ON rights.rank = user.rank WHERE user.id = :pid LIMIT 1;");
      $this->db->bind("pid", $user_id);
      $this->db->execute();
      // create session which stores the userdata
      $userdata = $this->db->single();
      $_SESSION["lg_sess"] = $userdata;
    }

    public function setRemeberMeCookie($userdata) {
      $expire = time() + 3600 * 24 * 60;
      setcookie("rememberMe", base64_encode($userdata["id"] + 1337), $expire,"/");

      $hash = md5(REMEMBER_ME_SALT."|".$userdata["id"]."|".substr($userdata["password"], 2, 4)."|".$userdata["email"]);
      setcookie("rememberMeToken", $hash, $expire,"/");
    }
}
