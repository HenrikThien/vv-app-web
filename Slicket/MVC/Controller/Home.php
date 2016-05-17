<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;

class Home extends BaseController {
  public function __construct() {
    parent::__construct("HomeModel");

    if (!$this->getModel()->isLoggedIn())
    {
      header("location: /Login/");
    }
  }

  public function index() {
    header("location: /ExportMasks/");
    /*
    $rank_name = strtolower($_SESSION["lg_sess"]["rank_name"]);

    $view = new BaseView("home.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
    $view->assign("user", $_SESSION["lg_sess"]);
    $view->assign("devices", $this->getModel()->list_of_all_devices());
    $view->display();
    */
  }

  public function settings() {
      $view = new BaseView("settings.tpl");
      $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
      $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
      $view->assign("user", $_SESSION["lg_sess"]);
      $view->display();
  }

  public function savesettings($type) {
      header('Content-Type: application/json');
      $response = array("valid" => false, "message" => "Fehler bei der Datenverarbeitung.");
      $session = $_SESSION["lg_sess"];

      if ($type == "password") {
          if (isset($_POST["oldpw"]) && isset($_POST["newpw1"]) && isset($_POST["newpw2"])) {
            $oldpw = htmlspecialchars($_POST["oldpw"]);
            $newpw1 = htmlspecialchars($_POST["newpw1"]);
            $newpw2 = htmlspecialchars($_POST["newpw2"]);

            if ($this->getModel()->check_password($session["id"], $oldpw)) {
                if ($newpw1 == $newpw2) {
                    $this->getModel()->update_password_for_user($session["id"], $newpw1);
                    $response["valid"] = true;
                    $response["message"] = "Das Passwort wurde aktualisiert.";
                } else {
                    $response["valid"] = false;
                    $response["message"] = "Die beiden neuen Passwörter stimmen nicht überein.";
                }
            } else {
                $response["valid"] = false;
                $response["message"] = "Das alte Passwort stimmt nicht!";
            }
          }
      }
      else if ($type == "email") {
          if (isset($_POST["email"])) {
            $email = htmlspecialchars($_POST["email"]);
            $this->getModel()->update_email_for_user($session["id"], $email);
            $response["valid"] = true;
            $response["message"] = "Die Email wurde aktualisiert und kann beim nächsten Anmelden genutzt werden.";
          }
      }

      echo json_encode($response);
  }

  // Home/Logout
  public function logout() {
    $this->getModel()->logout();
  }
}
