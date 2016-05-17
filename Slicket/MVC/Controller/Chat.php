<?php

namespace Slicket\MVC\Controller;

use Slicket\Library\BaseController as BaseController;
use Slicket\Library\BaseView as BaseView;
use Slicket\Library\Encryption as Encryption;
use Slicket\Library\Crypt\Crypt_AES as Crypt_AES;

class Chat extends BaseController {
  public function __construct() {
    parent::__construct("ChatModel");
  }
  
  public function index()
  {
    if (!$this->getModel()->isLoggedIn())
    {
      header("location: /Login/");
    }
    
    $view = new BaseView("chattemplate.tpl");
    $view->assign("url", URL.SMARTY_TEMPLATE_DIR.CMS_TEMPLATE);
    $view->assign("lang", $this->getLangParser()->getValuesForPage("home"));
    $view->assign("user", $_SESSION["lg_sess"]);
    $view->assign("chats", $this->getModel()->get_my_chats());
    $view->display();
  }

  public function publickey() {
    echo $this->getModel()->getEncryption()->get_public_key();
  }
  
  public function keyiv() {
    if (isset($_POST["key"]) && isset($_POST["iv"])) {
      echo $this->getModel()->getEncryption()->establish_connection($_POST["key"], $_POST["iv"]);
    } else {
      echo "Die Daten wurden nicht richtig uebertragen!";
    }
  }
  
  public function getmessages() {
    echo json_encode(array("valid" => false, "message" => "error loading rsa"));
  }
  
  public function message() {
    if (isset($_POST['message']) && isset($_POST["key"]) && isset($_POST["iv"])) {
      //$this->getModel()->getEncryption()->decryptMessage($_POST["message"], $_POST["key"], $_POST["iv"]);
      // todo: check if password is true, send password via POST
      $this->getModel()->saveEncryptedMessage($_POST["message"], $_POST["key"], $_POST["iv"]);
    } else {
      echo "Daten wurden nicht richtig uebertragen!";
    }
  }
}