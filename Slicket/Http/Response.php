<?php
namespace Slicket\Http;

/*
 * TODO: FINISH THIS CLASS
 */
class Response {
  private $_headers = array();
  private $_type = null;
  private $_content = null;

  public function __construct($type) {
    $this->_type = $type;
  }

  public function setContent($content) {
    $this->_content = $content;
  }

  public function setHeader($header) {
    array_push($header, $this->_headers);
  }

  public function output() {
    if ($this->_type == "json") {

    }
  }
}
