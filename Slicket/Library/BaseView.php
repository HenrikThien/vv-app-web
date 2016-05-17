<?php

namespace Slicket\Library;
use \Smarty as Smarty;

class BaseView {
  private $template;
    private $smarty;

    public function __construct($template) {
        $this->template = $template;
        $this->smarty = $this->createSmartyInstance();
    }

    private function createSmartyInstance() {
        $tempSmarty = new Smarty();

        $tempSmarty->template_dir   = SMARTY_TEMPLATE_DIR . "/" . CMS_TEMPLATE;
    		$tempSmarty->compile_dir    = SMARTY_TEMPLATE_C_DIR;
    		$tempSmarty->config_dir     = SMARTY_CONFIG_DIR;
    		$tempSmarty->cache_dir      = SMARTY_CACHE_DIR;
    		$tempSmarty->caching 	    = SMARTY_USE_CACHE;
    		$tempSmarty->cache_lifetime = SMARTY_CACHE_LIFETIME;

    		return $tempSmarty;
    }

    public function assign($key, $value) {
        $this->smarty->assign($key, $value);
    }

    public function display() {
        $this->smarty->display($this->template);
    }
}
