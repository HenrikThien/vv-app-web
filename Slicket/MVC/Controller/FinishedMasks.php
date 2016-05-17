<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;

class FinishedMasks extends BaseController {
  public function __construct() {
    parent::__construct("FinishedMasksModel");

    if (!$this->getModel()->isLoggedIn())
    {
      header("location: /Login/");
    }
  }
  
  public function index()
  {
    $view = new BaseView("finishedmasks.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
    $view->assign("user", $_SESSION["lg_sess"]);
    $view->assign("device_list", $this->getModel()->get_device_list());
    $view->display();
  }
  
  public function searchget() {
      header('Content-Type: application/json');
      $response = array("valid" => false, "message" => "", "patients" => null);   
      
      if (isset($_POST["groupid"])) {
          $group_id = htmlspecialchars($_POST["groupid"]);
          $response["valid"] = true;
          $response["message"] = "";
          $response["patients"] = $this->getModel()->search_masks($group_id);
      } else {
          $response["valid"] = false;
          $response["message"] = "Fehler bei der Datenübertragung!";
          $response["patients"] = array();
      }
      
      echo json_encode($response);
  }
  
  public function getpatients() {
      header('Content-Type: application/json');
      $response = array("valid" => false, "message" => "", "patients" => null);
      
      if (isset($_POST["id"])) {
          $mask_id = htmlspecialchars($_POST["id"]);
          
          $patients = $this->getModel()->search_patients($mask_id);
          
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
          $response["message"] = "Fehler bei der Datenübertragung!";
          $response["patients"] = array();
      }
      
      echo json_encode($response);
  }
  
  public function getpatientsforweek()
  {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "", "patients" => null);
    
    if (isset($_POST["mask_id"]))
    {
        $mask_id = htmlspecialchars($_POST["mask_id"]);
        $patients = $this->getModel()->get_patients_for_week($mask_id);

        $response["valid"] = true;
        $response["message"] = "Die Daten wurden erfolgreich verarbeitet.";
        $response["patients"] = $patients;
    }
    else
    {
        $response["valid"] = false;
        $response["message"] = "Es konnten keine Daten empfangen werden.";
    }
    
    echo json_encode($response);
  }
}