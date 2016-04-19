<?php

/** 
 * Komfortkasse
 * Config Class
 * 
 * @version 1.0.7-xtc4
 */
class Komfortkasse_Config {
	const activate_export = 'KOMFORTKASSE_ACTIVATE_EXPORT';
	const activate_update = 'KOMFORTKASSE_ACTIVATE_UPDATE';
	const payment_methods = 'KOMFORTKASSE_PAYMENT_CODES';
	const status_open = 'KOMFORTKASSE_STATUS_OPEN';
	const status_paid = 'KOMFORTKASSE_STATUS_PAID';
	const status_cancelled = 'KOMFORTKASSE_STATUS_CANCELLED';
	const payment_methods_invoice = 'KOMFORTKASSE_PAYMENT_CODES_INVOICE';
	const status_open_invoice = 'KOMFORTKASSE_STATUS_OPEN_INVOICE';
	const status_paid_invoice = 'KOMFORTKASSE_STATUS_PAID_INVOICE';
	const status_cancelled_invoice = 'KOMFORTKASSE_STATUS_CANCELLED_INVOICE';
	const payment_methods_cod = 'KOMFORTKASSE_PAYMENT_CODES_COD';
	const status_open_cod = 'KOMFORTKASSE_STATUS_OPEN_COD';
	const status_paid_cod = 'KOMFORTKASSE_STATUS_PAID_COD';
	const status_cancelled_cod = 'KOMFORTKASSE_STATUS_CANCELLED_COD';
	const encryption = 'KOMFORTKASSE_ENCRYPTION';
	const accesscode = 'KOMFORTKASSE_ACCESSCODE';
	const apikey = 'KOMFORTKASSE_APIKEY';
	const publickey = 'KOMFORTKASSE_PUBLICKEY';
	const privatekey = 'KOMFORTKASSE_PRIVATEKEY';
	
	// changing constants at runtime is necessary for init, therefore save them in cache
	private static $cache = array ();
	
	public static function setConfig($constant_key, $value) {
		global $db;
		$sql = "update " . TABLE_PLUGIN_CONFIGURATION . " set config_value=? where config_key=?";
		$db->execute($sql, array (
				$value,
				$constant_key 
		));
		self::$cache [$constant_key] = $value;
	}
	public static function getConfig($constant_key) {
		if (!array_key_exists($constant_key, self::$cache))
			self::$cache [$constant_key] = constant($constant_key);
		
		return self::$cache [$constant_key];
	}
	public static function getRequestParameter($key) {
		if ($_POST [$key])
			return urldecode($_POST [$key]);
		else
			return urldecode($_GET [$key]);
	}
	
	public static function getVersion() {
		global $db;
		$rs = $db->execute("select config_value from " . TABLE_CONFIGURATION . " where config_key='_SYSTEM_VERSION'");
		if (!$rs->EOF) {
			$f = $rs->fields;
			return $f ['config_value'];
		}
	}
}
?>