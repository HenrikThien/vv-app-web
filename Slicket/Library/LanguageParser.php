<?php

namespace Slicket\Library;

class LanguageParser {
    private $jsonFile = null;

    public function __construct($language) {
        $content = "[]";

        if (file_exists(LANG_DIR . "/" . LANG_FILE)) {
            $content = file_get_contents(LANG_DIR . "/" . $language . ".json");
        }
        else {
            $content = file_get_contents(LANG_DIR . "/" . LANG_FILE . ".json");
        }

        $this->jsonFile = json_decode($content, true);
    }

    public function getValue($path) {
        $object = explode('/', $path)[0];
        $key    = explode('/', $path)[1];

        return isset ($this->jsonFile[$object][$key]) ? $this->jsonFile[$object][$key] : array();
    }

    public function getValueAndReplace($path, $search, $replace) {
      $content = $this->getValue($path);

      return str_ireplace($search, $replace, $content);
    }

    public function getValuesForPageAndReplace($page, $search, $replace) {
      $content = $this->getValuesForPage($page);

      return str_ireplace($search, $replace, $content);
    }

    // MERGE FOOTER AND PAGE VARS!!!!!!
    public function getValuesForPage($page) {
        $page = "page_" . $page;

        $pageArr = isset ($this->jsonFile[$page]) ? $this->jsonFile[$page] : array();
        $footer  = isset ($this->jsonFile["footer"]) ? $this->jsonFile["footer"] : array();

        return array_merge($pageArr, $footer);
    }
}
