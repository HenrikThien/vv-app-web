<?php
// dont forget to add a "/" at the end
DEFINE ("URL", "http://app.visvitalis.info/");
DEFINE ("CMS_TEMPLATE", "adminlte");

/*
 * Database connection config
 */
DEFINE("DB_CON_TYPE", "PDODatabase"); // put classname here (Slicket/Library/Databases/)

DEFINE("DB_HOST", "db608574261.db.1and1.com");
DEFINE("DB_USER", "dbo608574261");
DEFINE("DB_PASSWORD", "htare51");
DEFINE("DB_NAME", "db608574261");

/*
 * Language config
 * Set by $_SESSION['lang']
 */
DEFINE ("LANG_FILE", "german");
DEFINE ("LANG_DIR", "Languages");

/*
 * Smarty config
 */
DEFINE('SMARTY_SPL_AUTOLOAD', 1);
DEFINE('SMARTY_TEMPLATE_DIR', 'Public/smarty/templates/');
DEFINE('SMARTY_TEMPLATE_C_DIR', 'Public/smarty/templates_c/');
DEFINE('SMARTY_CACHE_DIR', 'Public/smarty/cache/');
DEFINE('SMARTY_CONFIG_DIR', 'Public/smarty/configs/');
DEFINE('SMARTY_USE_CACHE', false); /* DISABLED FOR DEBUGGING */
DEFINE('SMARTY_CACHE_LIFETIME', 120);

/*
 * Remeber me token salt
 */
DEFINE ("REMEMBER_ME_SALT", "66174523855af85a0c8f201.39215860");

/*
 * Google API
 */
DEFINE ( 'API_ACCESS_KEY', 'AIzaSyCPzykQkhX7YAc8ooNw-opwNryQ1isaQZ0' );
