<?php

/**
 * Komfortkasse
 * Config Class
 *
 * @version 1.10.1-xtc4/5/6
 */
class Komfortkasse_Config
{
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


    public static function setConfig($constant_key, $value, $order = null)
    {
        $store_id = $order ? $order ['store_id'] : 0;


        global $db;
        $sql = "update " . TABLE_PLUGIN_CONFIGURATION . " set config_value=? where config_key=?";
        if ($order) {
            $sql .= " and shop_id=?";
            $db->execute($sql, array ($value,$constant_key,$store_id
            ));
        } else {
            $db->execute($sql, array ($value,$constant_key
            ));
        }

        $cache_key = $store_id . '_' . $constant_key;
        self::$cache [$cache_key] = $value;

    }


    public static function getConfig($constant_key, $order = null)
    {
        $store_id = null;
        if ($order != null) {
            $store_id = $order ['store_id'];
        } else {
            // export und update werden in den getId Methoden nochmals extra berücksichtigt.
            if ($constant_key == self::activate_export)
                return true;
            if ($constant_key == self::activate_update)
                return true;
        }
        if ($store_id === null)
            $store_id = 0;



        $cache_key = $store_id . '_' . $constant_key;
        if (!array_key_exists($cache_key, self::$cache))
            self::$cache [$cache_key] = constant($constant_key);

        return self::$cache [$cache_key];

    }


    public static function getRequestParameter($key)
    {
        if ($_POST [$key])
            return rawurldecode($_POST [$key]);
        else
            return rawurldecode($_GET [$key]);

    }


    public static function getVersion()
    {
        global $db;
        $rs = $db->execute("select config_value from " . TABLE_CONFIGURATION . " where config_key='_SYSTEM_VERSION'");
        if (!$rs->EOF) {
            $f = $rs->fields;
            return $f ['config_value'];
        }

    }


    public static function output($s)
    {
        echo $s;

    }

    public static function log($s)
    {
        // not implemented
    }
}
?>