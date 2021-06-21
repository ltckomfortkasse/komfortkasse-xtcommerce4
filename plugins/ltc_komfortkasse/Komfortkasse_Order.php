<?php

/**
 * Komfortkasse Order Class
 * in KK, an Order is an Array providing the following members:
 * number, date, email, customer_number, payment_method, amount, currency_code, exchange_rate, language_code
 * status: data type according to the shop system
 * delivery_ and billing_: _firstname, _lastname, _company, _street, _postcode, _city, _countrycode
 * products: an Array of item numbers
 * @version 1.10.3-xtc4/5/6
 */
class Komfortkasse_Order
{


    // return all order numbers that are "open" and relevant for transfer to kk
    public static function getOpenIDs()
    {
        global $db;
        $ret = array ();

        $sql_stores = "select shop_id from " . TABLE_MANDANT_CONFIG . " where shop_status=1";
        $param_store_ids = Komfortkasse_Config::getRequestParameter('s');
        if ($param_store_ids != '')
            $sql_stores .= " and shop_id in (" . $param_store_ids . ")";

        $rs_stores = $db->execute($sql_stores);

        while ( !$rs_stores->EOF ) {
            $f_stores = $rs_stores->fields;
            $store_id = $f_stores ['shop_id'];
            $store_id_order = [ ];
            $store_id_order ['store_id'] = $store_id;

            if (!Komfortkasse_Config::getConfig(Komfortkasse_Config::activate_export, $store_id_order)) {
                continue;
            }

            if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open, $store_id_order) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods, $store_id_order) != '') {
                $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open, $store_id_order) . ") and ( ";
                $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods, $store_id_order));
                for($i = 0; $i < count($paycodes); $i++) {
                    $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                    if ($i < count($paycodes) - 1) {
                        $sql .= " or ";
                    }
                }
                $sql .= " ) and shop_id=" . $store_id;
                $rs = $db->execute($sql);

                while ( !$rs->EOF ) {
                    $f = $rs->fields;
                    $ret [] = $f ['orders_id'];
                    $rs->moveNext();
                }
            }

            if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_invoice, $store_id_order) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_invoice, $store_id_order) != '') {
                $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_invoice, $store_id_order) . ") and ( ";
                $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_invoice, $store_id_order));
                for($i = 0; $i < count($paycodes); $i++) {
                    $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                    if ($i < count($paycodes) - 1) {
                        $sql .= " or ";
                    }
                }
                $sql .= " ) and shop_id=" . $store_id;
                $rs = $db->execute($sql);

                while ( !$rs->EOF ) {
                    $f = $rs->fields;
                    $ret [] = $f ['orders_id'];
                    $rs->moveNext();
                }
            }

            if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_cod, $store_id_order) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_cod, $store_id_order) != '') {
                $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_cod, $store_id_order) . ") and ( ";
                $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_cod, $store_id_order));
                for($i = 0; $i < count($paycodes); $i++) {
                    $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                    if ($i < count($paycodes) - 1) {
                        $sql .= " or ";
                    }
                }
                $sql .= " ) and shop_id=" . $store_id;
                $rs = $db->execute($sql);

                while ( !$rs->EOF ) {
                    $f = $rs->fields;
                    $ret [] = $f ['orders_id'];
                    $rs->moveNext();
                }
            }

            $rs_stores->moveNext();
        }
        return $ret;

    }


    public static function getOrder($number)
    {
        $order = new order($number, -1);
        if (empty($number) || empty($order) || $number != $order->order_data ['orders_id']) {
            return null;
        }

        $ret = array ();
        $ret ['number'] = $order->order_data ['orders_id'];
        $ret ['status'] = $order->order_data ['orders_status'];
        $ret ['date'] = $order->order_data ['date_purchased'];
        $ret ['email'] = $order->order_data ['customers_email_address'];
        $ret ['customer_number'] = $order->order_data [''];
        $ret ['payment_method'] = $order->order_data ['payment_code'];
        $ret ['payment_name'] = $order->order_data ['payment_name'];
        $ret ['amount'] = $order->order_total ['total'] ['plain'];
        $ret ['currency_code'] = $order->order_data ['currency_code'];
        $ret ['exchange_rate'] = $order->order_data ['currency_value'];
        $ret ['language_code'] = $order->order_data ['language_code'] . '-' . $order->order_data ['billing_country_code'];
        $ret ['delivery_firstname'] = html_entity_decode($order->order_data ['delivery_firstname']);
        $ret ['delivery_lastname'] = html_entity_decode($order->order_data ['delivery_lastname']);
        $ret ['delivery_company'] = html_entity_decode(trim($order->order_data ['delivery_company'] . ' ' . $order->order_data ['delivery_company_2'] . ' ' . $order->order_data ['delivery_company_3']));
        $ret ['delivery_street'] = html_entity_decode(trim($order->order_data ['delivery_street_address'] . ' ' . $order->order_data ['delivery_address_addition']));
        $ret ['delivery_postcode'] = $order->order_data ['delivery_postcode'];
        $ret ['delivery_city'] = html_entity_decode($order->order_data ['delivery_city']);
        $ret ['delivery_countrycode'] = $order->order_data ['delivery_country_code'];
        $ret ['delivery_phone'] = html_entity_decode($order->order_data ['delivery_phone']);
        $ret ['billing_firstname'] = html_entity_decode($order->order_data ['billing_firstname']);
        $ret ['billing_lastname'] = html_entity_decode($order->order_data ['billing_lastname']);
        $ret ['billing_company'] = html_entity_decode(trim($order->order_data ['billing_company'] . ' ' . $order->order_data ['billing_company_2'] . ' ' . $order->order_data ['billing_company_3']));
        $ret ['billing_street'] = html_entity_decode(trim($order->order_data ['billing_street_address'] . ' ' . $order->order_data ['billing_address_addition']));
        $ret ['billing_postcode'] = $order->order_data ['billing_postcode'];
        $ret ['billing_city'] = html_entity_decode($order->order_data ['billing_city']);
        $ret ['billing_countrycode'] = $order->order_data ['billing_country_code'];
        $ret ['billing_phone'] = html_entity_decode($order->order_data ['billing_phone']);

        $order_products = $order->order_products;
        foreach ($order_products as $product) {
            if ($product ['products_model']) {
                $ret ['products'] [] = html_entity_decode($product ['products_model']);
            } else {
                $ret ['products'] [] = html_entity_decode($product ['products_name']);
            }
        }

        if (file_exists(_SRV_WEBROOT . 'plugins/xt_orders_invoices/classes/class.xt_orders_invoices.php')) {
            require_once _SRV_WEBROOT . 'plugins/xt_orders_invoices/classes/class.xt_orders_invoices.php';
            if (class_exists('xt_orders_invoices')) {
                $xti = new xt_orders_invoices();
                if ($xti->isExistByOrderId($number) && !$xti->isExistByOrderIdCanceled($number)) {
                    $ret ['debug'] = 3;
                    $data = $xti->getOrderData($number);
                    foreach ($data as $invoice) {
                        $ret ['invoice_number'] [] = $invoice ['invoice_number_with_prefix'];
                        $ret ['invoice_date'] = date('d.m.Y', strtotime($invoice ['invoice_issued_date']));
                    }
                }
            }
        }

        return $ret;

    }


    public static function updateOrder($order, $status, $callbackid)
    {
        $order = new order($order ['number'], -1);
        $order->_updateOrderStatus($status, '', 'true', 'false', 'komfortkasse', $callbackid);

        // order status, comments, send mail, send comments, username, callback id
    }


    public static function getInvoicePdfPrepare()
    {

    }


    public static function getInvoicePdf($invoiceNumber, $orderNumber)
    {
        if ($invoiceNumber) {
            if (file_exists(_SRV_WEBROOT . 'plugins/xt_orders_invoices/classes/class.xt_orders_invoices.php')) {
                require_once _SRV_WEBROOT . 'plugins/xt_orders_invoices/classes/class.xt_orders_invoices.php';
                if (class_exists('xt_orders_invoices')) {
                    global $db;

                    $invoice = $db->Execute("SELECT i.invoice_id FROM " . TABLE_ORDERS_INVOICES . " AS i WHERE i.orders_id=? and concat(i.invoice_prefix, i.invoice_number)=?", array ($orderNumber,$invoiceNumber
                    ));
                    if (!$invoice->RecordCount())
                        return;
                    $id = $invoice->fields ['invoice_id'];
                    if (!id)
                        return;

                    $xti = new xt_orders_invoices();
                    $xti->url_data ['id'] = $id;
                    return $xti->getInvoicePdf();
                }
            }
        }

    }
}

?>