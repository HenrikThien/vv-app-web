<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;

class ExportMasks extends BaseController {
  public function __construct() {
    parent::__construct("ExportMasksModel");

    if (!$this->getModel()->isLoggedIn())
    {
      header("location: /Login/");
    }
  }
  
  public function index() {
    $view = new BaseView("exportmasks.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
    $view->assign("user", $_SESSION["lg_sess"]);
    $view->assign("device_list", $this->getModel()->get_device_list());
    $view->display();
  }
  
  public function getpatients() {
      header('Content-Type: application/json');
      $response = array("valid" => false, "message" => "", "patients" => null);
      
      if (isset($_POST["startDate"]) && isset($_POST["endDate"]) && isset($_POST["inputGroupNew"])) {
          $device = htmlspecialchars($_POST["inputGroupNew"]);
          $start = htmlspecialchars($_POST["startDate"]);
          $end = htmlspecialchars($_POST["endDate"]);
          
          $patients = $this->getModel()->search_patients($device, $start, $end);
          
          foreach ($patients as $key => $value) {
              $date = $value["date"];
              $parts = array(substr($date, 0, 2), substr($date, 2, 2), substr($date, 4, 2));
              
              $patients[$key]["date"] = implode('.', $parts);
          }
          
          $response["valid"] = true;
          $response["message"] = "";
          $response["patients"] = $patients;
      } else {
          $response["valid"] = false;
          $response["message"] = "Es konnten keine Daten übertragen werden.";
          $response["patients"] = array();
      }
      
      echo json_encode($response);
  }
}