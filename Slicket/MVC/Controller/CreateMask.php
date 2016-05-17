<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;

class CreateMask extends BaseController {
  public function __construct() {
    parent::__construct("CreateMaskModel");

    if (!$this->getModel()->isLoggedIn())
    {
      header("location: /Login/");
    }
  }

  public function index() {
    $view = new BaseView("createmask.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
    $view->assign("user", $_SESSION["lg_sess"]);
    $view->assign("week_nr", date("W"));
    $view->assign("all_devices", $this->getModel()->get_all_devices());
    $view->display();
  }

  public function getoldmasks($group_id) {
      header('Content-Type: application/json');

      if (is_null($group_id) || !is_numeric($group_id)) {
        echo "[]";
        die();
      }

      $result = $this->getModel()->get_old_masks_for_group($group_id);
      echo json_encode($result);
  }

  public function setfavorite($type) {
      header('Content-Type: application/json');

      if (isset($_POST["gid"]) && isset($_POST["mid"]) && !is_null($type) && is_numeric($type)) {
          $gid = htmlspecialchars($_POST["gid"]);
          $mid = htmlspecialchars($_POST["mid"]);
          $type = htmlspecialchars($type);

          $this->getModel()->set_favorite_mask($mid, $gid, $type);
          echo "[]";
      } else {
        echo "[]";
      }
  }

  public function createnewmask($group_id) {
      header('Content-Type: application/json');

      if (is_null($group_id) || !is_numeric($group_id)) {
        echo "[]";
        die();
      }

      $this->getModel()->create_new_mask($group_id);
      echo json_encode(array("success" => "true"));
  }

  public function changeposition() {
      header('Content-Type: application/json');
      $response = array();
      if (isset($_POST["data"][0]["value"]) && isset($_POST["data"][1])) {
          $mask_id = htmlspecialchars($_POST["data"][0]["value"]);
          $order_data = $_POST["data"][1];

          $this->getModel()->change_table_order($mask_id, $order_data);
          echo json_encode($response);
      } else {
          echo json_encode($response);
      }
  }

  public function getpatients() {
      header('Content-Type: application/json');

      if (isset($_POST["gid"]) && isset($_POST["mid"])) {
          $gid = htmlspecialchars($_POST["gid"]);
          $mid = htmlspecialchars($_POST["mid"]);

          echo json_encode($this->getModel()->get_masks_patients_by_id($mid, $gid));
      } else {
          echo "[]";
      }
  }

  public function createnew() {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "");

    if (isset($_POST["inputPatNr"]) && isset($_POST["inputPatFirstname"]) && isset($_POST["inputPatLastname"]) && isset($_POST["inputMission"]) && isset($_POST["inputPerformances"]) && isset($_POST["maskid"]) && isset($_POST["groupid"])) {
      $pat_nr = htmlspecialchars($_POST["inputPatNr"]);
      $pat_firstname = htmlspecialchars($_POST["inputPatFirstname"]);
      $pat_lastname = htmlspecialchars($_POST["inputPatLastname"]);
      $pat_mission = htmlspecialchars($_POST["inputMission"]);
      $pat_performances = htmlspecialchars($_POST["inputPerformances"]);
      $mask_id = htmlspecialchars($_POST["maskid"]);
      $group_id = htmlspecialchars($_POST["groupid"]);

      if (!empty($mask_id) && !empty($group_id) && !empty($pat_nr) && !empty($pat_firstname) && !empty($pat_lastname) && !empty($pat_mission) && !empty($pat_performances))
      {
        $response = $this->getModel()->save_patient_for_week($mask_id, $group_id, $pat_nr, $pat_firstname, $pat_lastname, $pat_mission, $pat_performances);
      }
      else
      {
        $response["valid"] = false;
        $response["message"] = "Es müssen alle Felder ausgefüllt werden.";
      }
    }
    else
    {
      $response["valid"] = false;
      $response["message"] = "Die Daten konnten nicht verarbeitet werden, bitte versuchen Sie es später erneut.";
    }

    echo json_encode($response);
  }

  public function deletemask() {
      header('Content-Type: application/json');

      if (isset($_POST["gid"]) && isset($_POST["mid"])) {
          $gid = htmlspecialchars($_POST["gid"]);
          $mid = htmlspecialchars($_POST["mid"]);

          echo json_encode($this->getModel()->delete_mask($mid, $gid));
      } else {
          echo "[]";
      }
  }

  public function removepatient() {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "");

    if (isset($_POST["patnr"]) && isset($_POST["masknr"])) {
      $patnr = htmlspecialchars($_POST["patnr"]);
      $masknr = htmlspecialchars($_POST["masknr"]);
      $theid = htmlspecialchars($_POST["theid"]);
      $patmis = htmlspecialchars($_POST["patmis"]);

      if (!empty($patnr) && !empty($masknr) && !empty($theid) && !empty($patmis)) {
        $this->getModel()->delete_patient($patnr, $masknr, $theid, $patmis);
        $response["valid"] = true;
        $response["message"] = "Der Patient wurde erfolgreich gel&ouml;scht.";
      }
      else {
        $response["valid"] = false;
        $response["message"] = "Fehler beim Löschen des Patienten, es existiert m&ouml;glicherwei&szlig;e kein Datensatz.";
      }
    }
    else {
      $response["valid"] = false;
      $response["message"] = "Es konnten keine Daten &uuml;bertragen werden. Versuchen Sie es später erneut.";
    }

    echo json_encode($response);
  }

  public function sendtodevice() {
    header('Content-Type: application/json');
    $response = array("success" => 0, "message" => "");

    if (isset($_POST["device_id"]) && isset($_POST["mask_id"]))
    {
      $device_id = htmlspecialchars($_POST["device_id"]);
      $mask_id = htmlspecialchars($_POST["mask_id"]);

      if (!empty($device_id) && !empty($mask_id))
      {
        echo $this->getModel()->send_notification_to_device($device_id, $mask_id);
      }
      else
      {
        $response["message"] = "Es konnte keine GeräteID oder MaskenID gefunden werden.";
        echo json_encode($response);
      }
    }
    else
    {
        $response["message"] = "Es konnten keine Daten &uuml;bermittelt werden.";
        echo json_encode($response);
    }
  }

  public function copymask() {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "");

    if (isset($_POST["cpmaskid"]) && isset($_POST["copyToGroup"]) && isset($_POST["cgroup"])) {
        $cpmaskid = htmlspecialchars($_POST["cpmaskid"]);
        $copy_to_group = htmlspecialchars($_POST["copyToGroup"]);
        $current_group = htmlspecialchars($_POST["cgroup"]);

        $this->getModel()->copy_mask($cpmaskid, $copy_to_group, $current_group);

        $response["valid"] = true;
        $response["message"] = "Erfolgreich kopiert..";
    }
    else {
        $response["valid"] = false;
        $response["message"] = "Es wurden keine Daten übertragen!";
    }

    echo json_encode($response);
  }
}
