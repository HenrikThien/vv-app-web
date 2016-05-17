<?php

namespace Slicket\Library;

// MAKE SURE TO ADD ALL DATABASES HERE!!
use Slicket\Library\Databases\PDODatabase as PDODatabase;

abstract class BaseController {
  private $dbName = DB_CON_TYPE;
  private $model = null;
  private $db = null;
  private $langParser = null;

  public function __construct($model) {
    $this->db = new PDODatabase(); // TODO CHANGE

    $this->loadParserBySession();
    $this->loadModel($model);
  }

  public function loadParserBySession() {
    $lang = isset($_SESSION["lang"]) ? $_SESSION["lang"] : LANG_FILE;
    $this->langParser = new LanguageParser($lang);
  }

  private function loadModel($model) {
        $modelClass = "Slicket\\MVC\\Models\\".$model;
        if (class_exists($modelClass)) {
            $this->model = new $modelClass($this->db);
        }
    }

    protected final function getModel() {
        return $this->model;
    }

    protected final function getLangParser() {
      return $this->langParser;
    }

    protected final function getLangValue($path) {
        return $this->langParser->getValue($path);
    }

    // need to be implemented
    public abstract function index();
}
