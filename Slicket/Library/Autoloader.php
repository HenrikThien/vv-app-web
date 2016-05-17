<?php

namespace Slicket\Library;

require_once 'Slicket/Config/Config.php';

function autoload_class ( $namespace_class ) { 
	// Adapt to OS. Windows uses '\' as directory separator, linux uses '/'
	$path_file = str_replace( '\\', DIRECTORY_SEPARATOR, $namespace_class ); 
	// Get the autoload extentions in an array 
	$autoload_extensions = explode( ',', spl_autoload_extensions() ); 
	// Loop over the extensions and load accordingly 
	foreach( $autoload_extensions as $autoload_extension ) { 
		include_once( $path_file . $autoload_extension ); 
	} 
} 
// Setting the path (I use linux) so our includes work. 
set_include_path( get_include_path() . PATH_SEPARATOR . './' ); 
// Only try to autoload files with this extension(s) 
spl_autoload_extensions( '.php' ); 
// Register our autoload_class function as the spl_autoload implementation to use 
spl_autoload_register( 'Slicket\Library\autoload_class' );

require_once 'Slicket/Library/SmartyLibs/Smarty.class.php';
require_once 'Slicket/Library/OAuth2/Autoloader.php';