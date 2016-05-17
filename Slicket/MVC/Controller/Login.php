<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;

class Login extends BaseController {
  public function __construct() {
    parent::__construct("LoginModel");

    // if already logged in
    if ($this->getModel()->isLoggedIn()) {
      header("location: /Home/");
      exit;
    }

    // if session is unavailable check cookies to eat
    if ($this->getModel()->isCookieValid()) {
      // todo: refresh cookie?
      header("location: /Home/");
      exit;
    }
  }

  public function index() {
    $view = new BaseView("login.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("login"));
    $view->display();
  }

  public function locked() {

  }

  public function auth() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      header('Content-Type: application/json');
      $response = array("valid" => false, "message" => "");

      if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["password"]);

        $login = $this->getModel()->isLoginValid($email, $password);

        // is login valid?
        if ($login["valid"])
        {
          // create new session
          $this->getModel()->createSession($login["id"]);
          // create new cookie if wanted
          if (isset($_POST["rem_me"]))
          {
            $this->getModel()->setRemeberMeCookie($_SESSION["lg_sess"]);
          }

          $response["valid"] = true;
          $response["message"] = $this->getLangParser()->getValue("system/login_response_valid");
        }
        else {
          $response["valid"] = false;
          $response["message"] = $this->getLangParser()->getValue("system/login_response_unvalid");
        }
      } else {
        $response["valid"] = false;
        $response["message"] = $this->getLangParser()->getValue("system/login_post_not_found");
      }

      echo json_encode($response);
    }
    else {
      die("[]");
    }
  }
}
