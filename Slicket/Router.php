<?php
namespace Slicket;

use ReflectionClass as ReflectionClass;
use Slicket\MVC\Controller\Home as Home;

class Router {
  // http://xxx.de/CONTROLLER/
  private $url_controller;
  // http://xxx.de/CONTROLLER/ACTION/
  private $url_action;
  // http://xxx.de/CONTROLLER/ACTION/PARAM1/PARAM2..
  private $url_params = array();

  public function __construct() {
      // try to parse the given URL
      $this->parseUrl();
      // check if controller class exists
      if (class_exists($this->url_controller) && !empty($this->url_controller)) {
          // create new instance of controller class
					$this->url_controller = new $this->url_controller;
          // check if methods exists in class
					if (method_exists($this->url_controller, $this->url_action)) {
              // try run with parameter
							$this->runMethodWithParams();
					} else {
              // show index if method was not found
							$this->url_controller->index();
					}
      } else {
          // show defined controller (in config)
					$Home = new Home();
					$Home->index();
			}
  }

	private function runMethodWithParams() {
      // parameter to add
			$paramsToAdd = array();
      // loop through url parameter and add them if not NULL
			foreach ($this->url_params as $parameter) {
					if (!is_null($parameter)) {
							array_push($paramsToAdd, $parameter);
					}
			}

      // check number of required parameter
			$num_of_params = $this->checkMissingParams();

      // add NULL to array
			if (count($paramsToAdd) < $num_of_params) {
					for ($i = 0; $i < ($num_of_params - count($paramsToAdd)); $i++) {
							array_push($paramsToAdd, null);
					}
			}

      // call the function
			call_user_func_array(array($this->url_controller, $this->url_action), $paramsToAdd);
	}


	private function checkMissingParams() {
      // get count of required parameters for a function
			$class_reflection = new ReflectionClass($this->url_controller);
			return $class_reflection->getMethod($this->url_action)->getNumberOfParameters();
	}

  private function parseUrl() {
      // GET ?route=
      if (filter_input(INPUT_GET, 'route')) {
          // split URL up
          $url = explode('/', rtrim(htmlspecialchars($_GET["route"]), '/'), FILTER_SANITIZE_URL);

          // get controller class
          $this->url_controller = 'Slicket\\MVC\\Controller\\'. (isset($url) ? $url[0] : null);
          // set action
          $this->url_action     = (isset($url[1]) ? $url[1] : null);
          // param count
          $param_count = count($url) - 2;

          // add parameter to array
          for ($i = 0; $i < $param_count; $i++) {
              $parameter = (isset($url[$i + 2]) ? $url[$i + 2] : null);
              $this->url_params[$i] = $parameter;
          }
      }
  }
}
