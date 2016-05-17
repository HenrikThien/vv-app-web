<?php

namespace Slicket\Library;

abstract class BaseModel {
  final public function isLoggedIn() {
    return isset($_SESSION["lg_sess"]);
  }
  final public function logout() {
    session_destroy();
    unset($_SESSION["lg_sess"]);

    if (isset($_COOKIE["rememberMe"])) {
      unset($_COOKIE["rememberMe"]);
      setcookie('rememberMe', '', time() - 3600, '/');
    }
    if (isset($_COOKIE["rememberMeToken"])) {
      unset($_COOKIE["rememberMeToken"]);
      setcookie('rememberMeToken', '', time() - 3600, '/');
    }

    header('location: /Home/');
  }

  final public function createCookieData($user_id) {
    $this->db->query("SELECT id,email,password FROM user WHERE id = :pid LIMIT 1;");
    $this->db->bind("pid", $user_id);
    $this->db->execute();

    return $this->db->single();
  }

  final public function isCookieValid() {
    if (isset($_COOKIE["rememberMe"]) && isset($_COOKIE["rememberMeToken"]))
    {
      $userId = base64_decode($_COOKIE["rememberMe"]) - 1337;

      if ($userId > 0) {
        $this->createCookieData($userId);
        $userdata = $this->createCookieData($userId);

        $hash = md5(REMEMBER_ME_SALT."|".$userdata["id"]."|".substr($userdata["password"], 0, 5)."|".$userdata["email"]);

        if ($hash == $_COOKIE["rememberMeToken"]) {
          $_SESSION["lg_sess"] = $userdata;
          return true;
        }
      }
    }
    return false;
  }
}
