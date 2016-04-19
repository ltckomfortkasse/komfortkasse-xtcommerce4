<?php 
/**
 * Komfortkasse
 * routing
 *
 * @version 1.1.7-xtc4
 */

ini_set('default_charset', 'utf-8');

if(!extension_loaded("IonCube Loader")) {
	// check for custom "ini.php" file in base dir of store and copy it here
	
	if ( (!file_exists("php.ini") && file_exists("../../php.ini")) || (file_exists("php.ini") && file_exists("../../php.ini") && sha1_file("php.ini") != sha1_file("../../php.ini")) ) 
	{
		if (copy("../../php.ini", "php.ini")) {
			echo "PHP Configuration has been adapted (php.ini file was copied from base dir). Please retry.";
		} else {
			echo "IonCube Loader not loaded. Copying php.ini from base dir failed.";
		}
	} else {
		echo "IonCube Loader not loaded.";
	}
	die;
}

$basepath = explode('plugins', $_SERVER['SCRIPT_FILENAME']) ;
require_once ($basepath[0].'xtCore/main.php');

include_once 'Komfortkasse.php';

$action = Komfortkasse_Config::getRequestParameter('action');

$kk = new Komfortkasse();
$kk->$action();

?>