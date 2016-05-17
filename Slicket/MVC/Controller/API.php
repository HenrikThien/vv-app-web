<?php

namespace Slicket\MVC\Controller;
use Slicket\Library\BaseController as BaseController;
use OAuth2 as OAuth2;

class API extends BaseController {
  public function __construct() {
    parent::__construct("APIModel");
  }

  public function index() {
    die("[]");
  }

  public function token() {
    header('Content-Type: application/json');
    // Handle a request for an OAuth2.0 Access Token and send the response to the client
    $this->getModel()->server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();
  }

  public function authuser() {
      header('Content-Type: application/json');
      if (isset($_POST["groupname"]) && isset($_POST["password"])) {
        $groupname = htmlspecialchars($_POST["groupname"]);
        $password = htmlspecialchars($_POST["password"]);

        if (!empty($groupname) && !empty($password))
        {
          $response = $this->getModel()->verify_user($groupname, $password);
          echo json_encode($response);
        }
        else {
          $response = array("valid" => false, "error" => "Der Gruppenname und das Passwort dürfen nicht leer sein.");
          echo json_encode($response);
        }
      }
      else {
        $response = array("valid" => false, "error" => "Es wurde kein Gruppenname und Passwort gefunden!");
        echo json_encode($response);
      }
  }
  
  public function tryupdate($id) {
      echo $this->getModel()->tryupdate($id);
  }
  
  public function checkupdate() {
      header('Content-Type: application/json');
      $currentVersion = 10;
      
      if (!$this->getModel()->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
          $this->getModel()->server->getResponse()->send();
          die;
      } 
      
      $response = array("valid" => false, "message" => "Error.", "newest_version" => $currentVersion);
      
      if (isset($_POST["app_version"])) {
          $response["valid"] = true;
          $response["message"] = "Das neuste Update wird heruntergeladen.";
      }
      
      echo json_encode($response);    
  }
  
  public function downloadupdate($version) {
      $file_path = 'Public/files/visvitalis-'. $version .'.apk';
      $mm_type = "application/octet-stream";
      
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: public");
      header("Content-Description: File Transfer");
      header("Content-Type: " . $mm_type);
      header("Content-Length: " .(string)(filesize($file_path)) );
      header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
      header("Content-Transfer-Encoding: binary\n");
      
      readfile($file_path);
      exit();
  }
  
  public function register() {
      header('Content-Type: application/json');
      if (isset($_POST["groupname"]) && isset($_POST["token"])) {
        $groupname = htmlspecialchars($_POST["groupname"]);
        $token = htmlspecialchars($_POST["token"]);

        if (!empty($groupname) && !empty($token)) {
          $response = $this->getModel()->register_device($groupname, $token);
          echo json_encode($response);
        } else {
          $response = array("valid" => false, "message" => "Der Gruppenname und das Token dürfen nicht leer sein.");
          echo json_encode($response);
        }
      }
      else {
        $response = array("valid" => false, "message" => "Es wurde kein Gruppenname und Token gefunden!");
        echo json_encode($response);
      }
  }
  
  public function downloadfavomask() {
      if (!$this->getModel()->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
          $this->getModel()->server->getResponse()->send();
          die;
      }
      
      $response = array("valid" => false, "message" => "", "is_new" => false, "data" => null);
      
      if (isset($_POST["groupname"])) {
          $groupname = htmlspecialchars($_POST["groupname"]);

          $response["valid"] = true;
          $response["message"] = "Die Daten wurden erfolgreich generiert!";
          $data = $this->getModel()->create_json_mask_by_favo($groupname);
          $response["masknr"] = $data["masknr"];
          $response["is_new"] = (count($data) > 0) ? true : false;
          $response["data"] = array($data["mask"]);
      } else {
          $response["valid"] = false;
          $response["message"] = "Fehler bei der Datenverarbeitung.";
          $response["is_new"] = false;
          $response["data"] = array();
      }
      
      echo json_encode($response);
  }
  
  public function downloadmask()
  {
    if (!$this->getModel()->server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
      $this->getModel()->server->getResponse()->send();
      die;
    }

    $response = array("valid" => false, "message" => "", "data" => null);

    if (isset($_POST["groupname"]) && isset($_POST["masknr"]))
    {
      $groupname = htmlspecialchars($_POST["groupname"]);
      $mask_nr = htmlspecialchars($_POST["masknr"]);

      if (!empty($groupname) && !empty($mask_nr))
      {
        $response["valid"] = true;
        $response["data"] = array($this->getModel()->create_json_mask($groupname, $mask_nr));
        $response["message"] = "Die Daten wurden erfolgreich generiert!";
      }
      else
      {
        $response["valid"] = false;
        $response["message"] = "Es ist kein Gruppenname oder keine Maskennummer verfügbar.";
      }
    }
    else
    {
      $response["valid"] = false;
      $response["message"] = "Es konnten keine Daten zum Server übertragen werden!";
    }

    echo json_encode($response);
  }
  
  public function uploadfinishedmask() {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "");
    
    if (isset($_POST["data"]))
    {
      $jsonmask = $_POST["data"];
      $response["valid"] = true;
      $response["message"] = "Die Maske wurde erfolgreich hochgeladen!";
      $this->getModel()->save_finished_patients_mask($jsonmask);
    }
    else
    {
      $response["valid"] = false;
      $response["message"] = "Die Maske konnte nicht hochgeladen werden.";
    }
    
    echo json_encode($response);
  }
  
  public function uploadfinishedmasknew() {
    header('Content-Type: application/json');
    $response = array("valid" => false, "message" => "");
    
    if (isset($_POST["data"]))
    {
      $jsonmask = $_POST["data"];
      $response["valid"] = true;
      $response["message"] = "Die Maske wurde erfolgreich hochgeladen!";
      $this->getModel()->save_finished_patients_mask_new($jsonmask);
    }
    else
    {
      $response["valid"] = false;
      $response["message"] = "Die Maske konnte nicht hochgeladen werden.";
    }
    
    echo json_encode($response);
  }
}
