<?php

/**
 * Komfortkasse Order Class
 * in KK, an Order is an Array providing the following members:
 * number, date, email, customer_number, payment_method, amount, currency_code, exchange_rate, language_code
 * status: data type according to the shop system
 * delivery_ and billing_: _firstname, _lastname, _company, _street, _postcode, _city, _countrycode
 * products: an Array of item numbers
 * @version 1.7.7-xtc4/5
 */
class Komfortkasse_Order
{

    // return all order numbers that are "open" and relevant for tranfer to kk
    public static function getOpenIDs()
    {
        global $db;

        $ret = array ();
        if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods) != '') {
            $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open) . ") and ( ";
            $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods));
            for($i = 0; $i < count($paycodes); $i++) {
                $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                if ($i < count($paycodes) - 1) {
                    $sql .= " or ";
                }
            }
            $sql .= " )";
            $rs = $db->execute($sql);

            while ( !$rs->EOF ) {
                $f = $rs->fields;
                $ret [] = $f ['orders_id'];
                $rs->moveNext();
            }
        }

        if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_invoice) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_invoice) != '') {
            $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_invoice) . ") and ( ";
            $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_invoice));
            for($i = 0; $i < count($paycodes); $i++) {
                $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                if ($i < count($paycodes) - 1) {
                    $sql .= " or ";
                }
            }
            $sql .= " )";
            $rs = $db->execute($sql);

            while ( !$rs->EOF ) {
                $f = $rs->fields;
                $ret [] = $f ['orders_id'];
                $rs->moveNext();
            }
        }

        if (Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_cod) != '' && Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_cod) != '') {
            $sql = "select orders_id from " . TABLE_ORDERS . " where orders_status in (" . Komfortkasse_Config::getConfig(Komfortkasse_Config::status_open_cod) . ") and ( ";
            $paycodes = preg_split('/,/', Komfortkasse_Config::getConfig(Komfortkasse_Config::payment_methods_cod));
            for($i = 0; $i < count($paycodes); $i++) {
                $sql .= " payment_code like '" . $paycodes [$i] . "' ";
                if ($i < count($paycodes) - 1) {
                    $sql .= " or ";
                }
            }
            $sql .= " )";
            $rs = $db->execute($sql);

            while ( !$rs->EOF ) {
                $f = $rs->fields;
                $ret [] = $f ['orders_id'];
                $rs->moveNext();
            }
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
        $ret ['date'] = $order->order_data ['date_purchased'];
        $ret ['email'] = $order->order_data ['customers_email_address'];
        $ret ['customer_number'] = $order->order_data [''];
        $ret ['payment_method'] = $order->order_data ['payment_code'];
        $ret ['amount'] = $order->order_total ['total'] ['plain'];
        $ret ['currency_code'] = $order->order_data ['currency_code'];
        $ret ['exchange_rate'] = $order->order_data ['currency_value'];
        $ret ['language_code'] = $order->order_data ['language_code'] . '-' . $order->order_data ['billing_country_code'];
        $ret ['delivery_firstname'] = $order->order_data ['delivery_firstname'];
        $ret ['delivery_lastname'] = $order->order_data ['delivery_lastname'];
        $ret ['delivery_company'] = trim($order->order_data ['delivery_company'] . ' ' . $order->order_data ['delivery_company_2'] . ' ' . $order->order_data ['delivery_company_3']);
        $ret ['delivery_postcode'] = $order->order_data ['delivery_postcode'];
        $ret ['delivery_city'] = $order->order_data ['delivery_city'];
        $ret ['delivery_countrycode'] = $order->order_data ['delivery_country_code'];
        $ret ['billing_firstname'] = $order->order_data ['billing_firstname'];
        $ret ['billing_lastname'] = $order->order_data ['billing_lastname'];
        $ret ['billing_company'] = trim($order->order_data ['billing_company'] . ' ' . $order->order_data ['billing_company_2'] . ' ' . $order->order_data ['billing_company_3']);
        $ret ['billing_postcode'] = $order->order_data ['billing_postcode'];
        $ret ['billing_city'] = $order->order_data ['billing_city'];
        $ret ['billing_countrycode'] = $order->order_data ['billing_country_code'];

        $order_products = $order->order_products;
        foreach ($order_products as $product) {
            if ($product ['products_model']) {
                $ret ['products'] [] = $product ['products_model'];
            } else {
                $ret ['products'] [] = $product ['products_name']; // TODO testen
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

                    $invoice = $db->Execute("SELECT i.invoice_id FROM " . TABLE_ORDERS_INVOICES . " AS i WHERE i.orders_id=? and concat(i.invoice_prefix, i.invoice_number)=?", array($orderNumber, $invoiceNumber));
                    if (!$invoice->RecordCount())
                        return;
                    $id = $invoice->fields['invoice_id'];
                    if (!id)
                        return;

                    $xti = new xt_orders_invoices();
                    $xti->url_data['id'] = $id;
                    return $xti->getInvoicePdf();
                }
            }
        }

    }
}

?>