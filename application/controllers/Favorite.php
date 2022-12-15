<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Favorite extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $tableAvailable             = 1;

        $data['title']              = "POS | Milou Farm House";
        $data['kode']               = $this->M_Global->transactionNumber();
        $data['transaction']        = $this->M_Global->getData("Transaction")->result_array();
        $data['paymentMethod']      = $this->M_Global->getData("PaymentMethod")->result_array();
        $data['discount']           = $this->M_Global->getData("Discount")->result_array();
        $data['countCustomer']      = $this->M_Global->getDataWhereSumCustomer("Transaction", "StatusTransaction")->row_array();

        $this->render_page('pos/main/page-favorite/index', $data);
    }

    public function menuWithID($transactionNumber)
    {
        $tableAvailable             = 1;

        $data['title']              = "POS | Milou Farm House";
        $data['kode']               = $this->M_Global->transactionNumber();
        $data['price']              = [2000, 5000, 10000, 20000, 50000, 100000];
        $data['transaction']        = $this->M_Global->getData("Transaction")->result_array();
        $data['paymentMethod']      = $this->M_Global->getData("PaymentMethod")->result_array();
        $data['discount']           = $this->M_Global->getData("Discount")->result_array();
        $data['myTransaction']      = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->row_array();
        $data['transactionID']      = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction              = $data['transactionID'][0]["TransactionID"];
        $data['getItemTransaction'] = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $data['countCustomer']      = $this->M_Global->getDataWhereSumCustomer("Transaction", "StatusTransaction")->row_array();

        $this->render_page('pos/main/page-favorite/index', $data);
    }

    public function startTransaction()
    {
        $cashier                = $this->session->userdata('CashierLoginID');
        $cek                    = $this->M_Global->getDataWhere("CashierLogin", "CashierLoginID", $cashier)->result_array();
        $getIDOutlet            = $cek[0]["OutletID"];
        $dateNow                = date("Y-m-d H:i:s");
        $transactionNumber      = $this->M_Global->transactionNumber();
        $dateCreateNow          = date('Y-m-d H:i:s', strtotime('now'));

        $data = array(
            'TransactionDatetime'   => $dateNow,
            'TransactionNumber'     => $transactionNumber,
            'CustomerName'          => $this->input->post("customerName"),
            'MasterOutletID'        => $getIDOutlet,
            'CashierLoginID'        => $cashier,
            'TransactionType'       => $this->input->post("transType"),
            'created_at'            => $dateCreateNow
        );

        $this->M_Global->insert($data, 'Transaction');

        redirect(base_url("favorite-list/" . $transactionNumber));
    }

    public function getDataCloseBill($transactionNumber)
    {
        $data['title']              = "POS | Milou Farm House";
        $data["transaction"]        = $this->M_Global->query("SELECT * FROM Transaction LEFT JOIN MasterOutlet ON Transaction.MasterOutletID = MasterOutlet.MasterOutletID WHERE Transaction.TransactionNumber = '$transactionNumber'")->result_array();
        $checkTransactionID         = $data['transaction'][0]["TransactionID"];
        $data["paymentMethod"]      = $this->M_Global->getDataWhereJoin("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $checkTransactionID)->result_array();
        $itemTransaction            = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$checkTransactionID' AND Parent = 0")->result_array();

        $items = [];

        foreach ($itemTransaction as $key) {
            $idt    = $key['TransactionDetailID'];
            $array  = (array)$idt;

            foreach ($array as $arr) {
                $asd    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE Parent = '$arr' ")->result_array();
                $qwe    = [];

                foreach ($asd as $add) {
                    $qwe[] = array(
                        'TransactionDetailID'       => $add['TransactionDetailID'],
                        'TransactionID'             => $add['TransactionID'],
                        'MenuID'                    => $add['MenuID'],
                        'MenuName'                  => $add['MenuName'],
                        'MenuImage'                 => $add['MenuImage'],
                        'Price'                     => $add['Price'],
                        'Qty'                       => $add['Qty'],
                        'NoteDetail'                => $add['NoteDetail'],
                        'StatusForKitchen'          => $add['StatusForKitchen'],
                        'StatusTransactionDetail'   => $add['StatusTransactionDetail'],
                        'StatusDelivered'           => $add['StatusDelivered']
                    );
                }
            }

            $items[] = array(
                'TransactionDetailID'       => $key['TransactionDetailID'],
                'TransactionID'             => $key['TransactionID'],
                'MenuID'                    => $key['MenuID'],
                'MenuName'                  => $key['MenuName'],
                'MenuImage'                 => $key['MenuImage'],
                'Price'                     => $key['Price'],
                'Qty'                       => $key['Qty'],
                'NoteDetail'                => $key['NoteDetail'],
                'StatusForKitchen'          => $key['StatusForKitchen'],
                'StatusTransactionDetail'   => $key['StatusTransactionDetail'],
                'StatusDelivered'           => $key['StatusDelivered'],
                'Parent'                    => $qwe
            );
        }

        $data['transactionDetail'] = $items;

        echo json_encode($data);
    }

    public function getDataCloseBillForConfirm()
    {
        $statusTransactionClose = 1;
        $transaction            = $this->M_Global->getData2WhereDateNow("Transaction", "StatusTransaction", $statusTransactionClose)->result_array();

        echo json_encode($transaction);
    }

    public function getDetailOrder()
    {
        $idTransaction          = $this->input->post("id");
        $result                 = $this->M_Global->getDataJoinWhereDateNow("Transaction", "TransactionDetail", array("TransactionID", "transactionID"), "StatusTransaction", "TransactionID", $idTransaction)->result_array();

        echo json_encode($result);
    }

    public function getDetailOrderDineIn()
    {
        $idTransaction              = $this->input->post("id");
        $data['transaction']        = $this->M_Global->getDataWhereDateNowNew("Transaction", "TransactionID", $idTransaction)->result_array();
        $id                         = $data['transaction'][0]['TransactionID'];
        $data['count']              = $this->M_Global->query("SELECT COUNT(TransactionDetailID) as total FROM TransactionDetail WHERE TransactionID = '$id'")->row_array();
        $itemTransaction            = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$id' AND Parent = 0")->result_array();

        $items = [];

        foreach ($itemTransaction as $key) {
            $idt    = $key['TransactionDetailID'];
            $array  = (array)$idt;

            foreach ($array as $arr) {
                $asd    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE Parent = '$arr' ")->result_array();
                $qwe    = [];

                foreach ($asd as $add) {
                    $qwe[] = array(
                        'TransactionDetailID'       => $add['TransactionDetailID'],
                        'TransactionID'             => $add['TransactionID'],
                        'MenuID'                    => $add['MenuID'],
                        'MenuName'                  => $add['MenuName'],
                        'MenuImage'                 => $add['MenuImage'],
                        'Price'                     => $add['Price'],
                        'Qty'                       => $add['Qty'],
                        'NoteDetail'                => $add['NoteDetail'],
                        'StatusForKitchen'          => $add['StatusForKitchen'],
                        'StatusTransactionDetail'   => $add['StatusTransactionDetail'],
                        'StatusDelivered'           => $add['StatusDelivered']
                    );
                }
            }

            $items[] = array(
                'TransactionDetailID'       => $key['TransactionDetailID'],
                'TransactionID'             => $key['TransactionID'],
                'MenuID'                    => $key['MenuID'],
                'MenuName'                  => $key['MenuName'],
                'MenuImage'                 => $key['MenuImage'],
                'Price'                     => $key['Price'],
                'Qty'                       => $key['Qty'],
                'NoteDetail'                => $key['NoteDetail'],
                'StatusForKitchen'          => $key['StatusForKitchen'],
                'StatusTransactionDetail'   => $key['StatusTransactionDetail'],
                'StatusDelivered'           => $key['StatusDelivered'],
                'Parent'                    => $qwe
            );
        }

        $data['transactionDetail'] = $items;

        echo json_encode($data);
    }

    public function getFavorite()
    {
        $menuStatusShow = 1;

        $result = $this->M_Global->getDataWhereFavorite("MenuReadyOrder", "MenuStatusShow", "MenuName", $menuStatusShow)->result_array();

        echo json_encode($result);
    }

    public function getMenuAddOn()
    {
        $menuId = $this->input->post("menuId");
        $addon  = $this->M_Global->query("SELECT * FROM MenuReadyOrder WHERE MenuType = 'Main' AND MenuID = '$menuId'")->result_array();

        $id     = $addon[0]['AddOn'];
        $q      = json_decode($id);
        $addon  = [];

        foreach ($q as $qq) {
            $getnameaddon       = $this->M_Global->query("SELECT * FROM MenuReadyOrder WHERE MenuCode = '$qq'")->result_array();

            foreach ($getnameaddon as $gt) {
                $addon[] = array(
                    'MenuID'    => $gt['MenuID'],
                    'MenuName'  => $gt['MenuName'],
                    'MenuImage' => $gt['MenuImage'],
                    'MenuPrice' => $gt['MenuPrice'],
                    'MenuType'  => $gt['MenuType']
                );
            }
        }
        $result = $addon;
        echo json_encode($result);
    }

    public function getCategoryMenu()
    {
        $menuStatusShow = 1;
        $data   = $this->M_Global->getDataGroupBy("MenuReadyOrder", "MenuStatusShow", "CategoryName", $menuStatusShow)->result_array();

        echo json_encode($data);
    }

    public function getCartItem($transactionNumber)
    {
        $data['checkTransactionNumber'] = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction                  = $data['checkTransactionNumber'][0]["TransactionID"];
        $itemTransaction                = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idTransaction' AND Parent = 0 ")->result_array();
        $items = [];

        foreach ($itemTransaction as $key) {
            $id     = $key['MenuID'];
            $idt    = $key['TransactionDetailID'];
            $array  = (array)$idt;

            foreach ($array as $arr) {
                $asd    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE Parent = '$arr' ")->result_array();
                $qwe    = [];

                foreach ($asd as $add) {
                    $qwe[] = array(
                        'TransactionDetailID'       => $add['TransactionDetailID'],
                        'MenuID'                    => $add['MenuID'],
                        'MenuName'                  => $add['MenuName'],
                        'MenuImage'                 => $add['MenuImage'],
                        'Price'                     => $add['Price'],
                        'Qty'                       => $add['Qty'],
                        'NoteDetail'                => $add['NoteDetail'],
                        'Parent'                    => $add['Parent'],
                        'StatusTransactionDetail'   => $add['StatusTransactionDetail'],
                        'StatusForKitchen'          => $add['StatusForKitchen'],
                        'StatusDelivered'           => $add['StatusDelivered']
                    );
                }
            }

            $addon  = $this->M_Global->query("SELECT * FROM MenuReadyOrder WHERE MenuID = '$id' ")->result_array();

            foreach ($addon as $gt) {
                $df[] = array(
                    'MenuID'    => $gt['MenuID'],
                    'MenuType'  => $gt['MenuType']
                );
            }

            $items[] = array(
                'TransactionDetailID'       => $key['TransactionDetailID'],
                'MenuID'                    => $key['MenuID'],
                'MenuName'                  => $key['MenuName'],
                'MenuImage'                 => $key['MenuImage'],
                'Price'                     => $key['Price'],
                'Qty'                       => $key['Qty'],
                'NoteDetail'                => $key['NoteDetail'],
                'Parent'                    => $key['Parent'],
                'StatusTransactionDetail'   => $key['StatusTransactionDetail'],
                'StatusForKitchen'          => $key['StatusForKitchen'],
                'StatusDelivered'           => $key['StatusDelivered'],
                'Parent'                    => $qwe
            );
        }

        $data['getItemTransaction'] = $items;
        $data['menu'] = $df;

        echo json_encode($data);
    }

    public function getDiscount($transactionNumber)
    {
        $data['checkTransactionNumber'] = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction                  = $data['checkTransactionNumber'][0]["TransactionID"];
        $data['getItemTransaction']     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();

        echo json_encode($data);
    }

    public function getPaymentMethod($transactionNumber)
    {
        $checkTransactionNumber = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionNumber[0]["TransactionID"];
        $paymentMethod          = $this->M_Global->getDataJoin2TableWhere("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $idTransaction)->result_array();

        echo json_encode($paymentMethod);
    }

    public function getChanger($transactionNumber)
    {
        $data["checkTransactionNumber"] = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction                  = $data["checkTransactionNumber"][0]["TransactionID"];
        $data["paymentMethod"]          = $this->M_Global->getDataJoin2TableWhere("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $idTransaction)->result_array();
        $data["getItemTransaction"]     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();

        echo json_encode($data);
    }

    public function getTransaction()
    {
        $transaction    = $this->M_Global->getDataWhereOrderBy("Transaction", "StatusTransaction", "TransactionDatetime")->result_array();

        echo json_encode($transaction);
    }

    public function getTransactionForReload($transactionNumber)
    {
        $statusConfirm              = 1;
        $statusPreparing            = 2;

        $data['transaction']        = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction              = $data['transaction'][0]['TransactionID'];
        $data['transactionDetail']  = $this->M_Global->getData3Where("TransactionDetail", "StatusForKitchen", "StatusForKitchen", "TransactionID", $statusConfirm, $statusPreparing, $idTransaction)->result_array();
        $data['count']              = $this->M_Global->getDataWhereCount("TransactionDetail", "StatusForKitchen", "StatusForKitchen", "TransactionID", $statusConfirm, $statusPreparing, $idTransaction)->row_array();

        echo json_encode($data);
    }

    public function getUpdateItemCart()
    {
        $transactionDetailID    = $this->input->post("id");
        $getItemTransaction     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionDetailID", $transactionDetailID)->result_array();

        echo json_encode($getItemTransaction);
    }

    public function addToCart($transactionNumber)
    {
        $check              = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction      = $check[0]["TransactionID"];

        $data = array(
            'TransactionID'         => $idTransaction,
            'MenuID'                => $this->input->post("menu_id", TRUE),
            'MenuName'              => $this->input->post("menu_name", TRUE),
            'MenuImage'             => $this->input->post("menu_image", TRUE),
            'Price'                 => $this->input->post("menu_price", TRUE),
            'Qty'                   => $this->input->post("menu_quantity", TRUE),
            'PriceAfterDiscount'    => '',
            'NoteDetail'            => '',
            'created_at'            => date('Y-m-d H:i:s', strtotime('now'))
        );
        $result = $this->M_Global->insert($data, "TransactionDetail");

        /* $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $subTotal               = $countSubTotal[0]['total'];

        $array = array(
            "SubTotalTransaction"   => $subTotal
        );
        $result = $this->M_Global->update("Transaction", $array, array("TransactionID" => $idTransaction)); */

        echo json_encode($result);
    }

    public function addOnMenu($transactionNumber)
    {
        $check                  = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $check[0]["TransactionID"];
        $menuId                 = $this->input->post('menuIdAddOn');
        $transactionDetailId    = $this->input->post('transactiondetailid');
        $menuCreated            = date('Y-m-d H:i:s', strtotime('now'));

        for ($i = 0; $i < sizeof($menuId); $i++) {
            $idMenu = $menuId[$i];
            $menuGet = $this->M_Global->query("SELECT * FROM MenuReadyOrder WHERE MenuID = '$idMenu' ")->result_array();

            $data = array(
                'TransactionID'         => $idTransaction,
                'MenuID'                => $idMenu,
                'MenuName'              => $menuGet[0]['MenuName'],
                'MenuImage'             => $menuGet[0]['MenuImage'],
                'Price'                 => $menuGet[0]['MenuPrice'],
                'Qty'                   => 1,
                'PriceAfterDiscount'    => '',
                'NoteDetail'            => '',
                'Parent'                => $transactionDetailId,
                'created_at'            => $menuCreated[$i]
            );
            $result = $this->M_Global->insert($data, "TransactionDetail");
        }
        echo json_encode($result);
    }

    public function addNotes()
    {
        $transactionDetailID    = $this->input->post("id");

        $data = array(
            'NoteDetail'    => $this->input->post("notes"),
            'update_at'     => date('Y-m-d H:i:s', strtotime('now'))
        );
        $result = $this->M_Global->update("TransactionDetail", $data, array("TransactionDetailID" => $transactionDetailID));

        echo json_encode($result);
    }

    public function increment_decrementQtyCart($transactionNumber)
    {
        $check                  = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $check[0]["TransactionID"];
        $getItemTransaction     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $idTransactionDetail    = $this->input->post("transaction_detail_id", TRUE);

        $data = array(
            'TransactionID' => $idTransaction,
            'Qty'           => $this->input->post("menu_quantity", TRUE)
        );
        $result = $this->M_Global->update("TransactionDetail", $data, array("TransactionDetailID" => $idTransactionDetail));

        $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $subTotal               = $countSubTotal[0]['total'];

        $array = array(
            "SubTotalTransaction"   => $subTotal
        );
        $result = $this->M_Global->update("Transaction", $array, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function destroyCartItem($transactionNumber)
    {
        $check                  = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $check[0]["TransactionID"];
        $getItemTransaction     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $idTransactionDetail    = $this->input->post("transaction_detail_id", TRUE);

        $asd                    = $this->M_Global->getDataWhere("TransactionDetail", "Parent", $idTransactionDetail)->result_array();

        foreach ($asd as $ss) {
            if ($ss['Parent'] == $idTransactionDetail) {
                $result = $this->M_Global->delete("TransactionDetail", array('TransactionDetailID' => $ss['TransactionDetailID']));
            } else {
                echo "error";
            }
        }

        $result = $this->M_Global->delete("TransactionDetail", array("TransactionDetailID" => $idTransactionDetail));

        $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $subTotal               = $countSubTotal[0]['total'];

        $array = array(
            "SubTotalTransaction"   => $subTotal
        );
        $result = $this->M_Global->update("Transaction", $array, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function destroyAllCartItem($transactionNumber)
    {
        $check                  = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $check[0]["TransactionID"];
        $getItemTransaction     = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $idTransactionDestroy   = $getItemTransaction[0]["TransactionID"];

        $result = $this->M_Global->delete("TransactionDetail", array("TransactionID" => $idTransactionDestroy));

        $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $subTotal               = $countSubTotal[0]['total'];

        $array = array(
            "SubTotalTransaction"   => $subTotal
        );
        $result = $this->M_Global->update("Transaction", $array, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function saveDiscount($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];
        $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $subTotal               = $countSubTotal[0]['total'];

        $discounts              = $this->input->post("discounts");
        $getDiscount            = $this->M_Global->getDataWhere("Discount", "DiscountID", $discounts)->result_array();
        $discountType           = $getDiscount[0]['DiscountType'];
        $discountValue          = $getDiscount[0]['DiscountValue'];

        if ($discountType == 1) {
            $totalDiscount = $discountValue;
        } else {
            $totalDiscount = $subTotal * $discountValue / 100;
        }

        $data = array(
            "DiscountTransID"   => $discounts,
            "Discount"          => $totalDiscount,
            "update_at"         => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->M_Global->update("Transaction", $data, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function removeDiscount($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];

        $data = array(
            "Discount"          => 0,
            "update_at"         => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->M_Global->update("Transaction", $data, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function saveMethodPayment($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];
        $nominal                = $this->input->post("inputCash");
        $nominal_str            = preg_replace("/[^0-9]/", "", $nominal);
        $nominal_int            = (int) $nominal_str;

        $data = array(
            "TransactionID"     => $idTransaction,
            "PaymentMethodID"   => $this->input->post("idPaymentMethod"),
            "Nominal"           => $nominal_int,
            "created_at"        => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->M_Global->insert($data, "PayMethodTrans");

        echo json_encode($result);
    }

    public function removePaymentMethod($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];
        $checkPaymentMethod     = $this->M_Global->getDataJoin2TableWhere("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $idTransaction)->result_array();
        $payMethodTransID       = $this->input->post("id", TRUE);

        $result = $this->M_Global->delete("PayMethodTrans", array("PayMethodTransID" => $payMethodTransID));

        echo json_encode($result);
    }

    public function closeBill($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];
        $masterOutletID         = $checkTransactionID[0]["MasterOutletID"];
        $subTotal               = $checkTransactionID[0]["SubTotalTransaction"];
        $transactionType        = $checkTransactionID[0]["TransactionType"];
        $countSubTotal          = $this->M_Global->getDataWhereSum("TransactionDetail", "TransactionID", $idTransaction)->result_array();
        $checkTransactionDetail = $this->M_Global->query("SELECT * FROM TransactionDetail LEFT JOIN MenuReadyOrder ON TransactionDetail.MenuID = MenuReadyOrder.MenuID LEFT JOIN Recipt ON MenuReadyOrder.MenuCode = Recipt.MenuCode WHERE TransactionDetail.TransactionID = '$idTransaction'")->result_array();
        $items = [];

        foreach ($checkTransactionDetail as $key) {
            
            $items = array(
                "MasterOutletID"    => $masterOutletID,
                "MasterItemID"      => $key['MasterItemID'],
                "QtyUsageMenu"      => $key['QtyUsageMenu']
            );
                
                $jsonBody = http_build_query($items);

                $url = 'http://151.106.113.196:8097/InsertCron/decrease_stock';


                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                $responseJson = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                echo $responseJson;
                curl_close($ch);    
        }


        exit();

        $customerID             = null;
        $pointRedeem            = 0;
        $pointObtain            = 0;
        $payMethodTransID       = 0;
        $discountTransID        = 0;
        $subTotal               = $countSubTotal[0]['total'];
        $discount               = $checkTransactionID[0]['Discount'];
        $dateUpdateNow          = date('Y-m-d H:i:s', strtotime('now'));

        if ($transactionType == 1) {
            $statusTransaction      = 5;
        } else {
            $statusTransaction      = 1;
        }

        if ($discount < $subTotal) {
            $totalTransaction       = $subTotal - $discount;
            $totalServiceCharge     = $totalTransaction * 7 / 100;
            $totalServiceSubtotal   = $totalTransaction + $totalServiceCharge;
            $totalPPN               = $totalServiceSubtotal * 10 / 100;
            $grandTotalTransaction  = $totalServiceSubtotal + $totalPPN;
        } else {
            $totalTransaction       = 0;
            $totalPPN               = 0;
            $totalServiceCharge     = 0;
            $grandTotalTransaction  = 0;
        }

        $data = array(
            'CustomerID'            => $customerID,
            'SubTotalTransaction'   => $subTotal,
            'PointRedeem'           => $pointRedeem,
            'TotalTransaction'      => $totalTransaction,
            'PPN'                   => $totalPPN,
            'ServiceCharge'         => $totalServiceCharge,
            'GrandTotalTransaction' => ceil($grandTotalTransaction / 100) * 100,
            'PointObtain'           => $pointObtain,
            'PayMethodTransID'      => $payMethodTransID,
            'DiscountTransID'       => $discountTransID,
            'StatusTransaction'     => $statusTransaction,
            'update_at'             => $dateUpdateNow
        );
        $result = $this->M_Global->update("Transaction", $data, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function liveSearchMenu()
    {
        $menuStatusShow = 1;
        $query  = "";
        if ($this->input->post("query")) {
            $query = $this->input->post("query");
        }

        $result = $this->M_Global->liveSearchDataMenu("MenuReadyOrder", "MenuStatusShow", "MenuName", "MenuName", $query, $menuStatusShow)->result();

        echo json_encode($result);
    }

    public function liveSearchListCustomer()
    {
        $query = "";
        if ($this->input->post("query")) {
            $query = $this->input->post("query");
        }

        $result = $this->M_Global->liveSearchDataCustomer("Transaction", "TransactionID", "CustomerName", "StatusTransaction", $query)->result();

        echo json_encode($result);
    }

    public function updateStatusTransaction()
    {
        $idTransaction  = $this->input->post("id");

        $data = array(
            'StatusTransaction' => 2,
            'update_at'         => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->M_Global->update("Transaction", $data, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function updateStatusTransactionComplete()
    {
        $idTransaction  = $this->input->post("id");
        $idTable        = $this->input->post("idTable");

        $dataTransaction = array(
            'StatusTransaction' => 5,
            'update_at'         => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result = $this->M_Global->update("Transaction", $dataTransaction, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function updateTable()
    {
        $tableNumber        = $this->input->post("tableNumber");
        $idTransaction      = $this->input->post("idTransaction");
        // $transType          = $this->input->post("transType");

        $dataTransactionDetail = array(
            'StatusForKitchen'  => 1,
            'update_at'         => date('Y-m-d H:i:s', strtotime('now'))
        );
        $result             = $this->M_Global->update("TransactionDetail", $dataTransactionDetail, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function updateTableForDineIn()
    {
        $tableNumber        = $this->input->post("tableNumber");
        $idTransaction      = $this->input->post("idTransaction");

        $dataTransaction = array(
            'TableNumber'       => $tableNumber,
            'update_at'         => date('Y-m-d H:i:s', strtotime('now'))
        );

        $result             = $this->M_Global->update("Transaction", $dataTransaction, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function confirmForDineIn()
    {
        $idTransactionDetail    = $this->input->post('idTransactionDetail');
        $idTransaction          = $this->input->post("idTransaction");

        $dataTransactionDetail = array(
            'StatusForKitchen'  => 1,
            'update_at'         => date('Y-m-d H:i:s', strtotime('now'))
        );
        $result = $this->M_Global->update("TransactionDetail", $dataTransactionDetail, array("TransactionDetailID" => $idTransactionDetail));

        echo json_encode($result);
    }

    public function itemsDelivered()
    {
        $statusDelivered    = $this->input->post("delivered");
        $detailID           = $this->input->post("detailID");

        $data = array(
            'StatusDelivered' => $statusDelivered
        );

        $result = $this->M_Global->update("TransactionDetail", $data, array("TransactionDetailID" => $detailID));

        echo json_encode($result);
    }

    public function updateCash($transactionNumber)
    {
        $checkTransactionID     = $this->M_Global->getDataWhere("Transaction", "TransactionNumber", $transactionNumber)->result_array();
        $idTransaction          = $checkTransactionID[0]["TransactionID"];
        $checkPaymentMethod     = $this->M_Global->getDataJoin2TableWhere("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $idTransaction)->result_array();
        $grandTotal             = $checkTransactionID[0]["GrandTotalTransaction"];
        $updated                = date('Y-m-d H:i:s', strtotime('now'));
        $countPayment           = 0;

        foreach ($checkPaymentMethod as $value) {
            $idPaymentMethod    = $value['PaymentMethodID'];
            $namePaymentMethod  = $value['PaymentMethodName'];
            $nominalPayment     = $value['Nominal'];
            $countPayment += $nominalPayment;
        }

        $change = $countPayment - $grandTotal;

        if ($change >= 0 || $idPaymentMethod == 1 || $namePaymentMethod == 'Cash') {
            $realCash = $nominalPayment - $change;
        } else {
            $realCash = $nominalPayment;
        }

        $this->M_Global->query("UPDATE PayMethodTrans SET Nominal = $realCash, updated_at = '$updated' WHERE TransactionID = $idTransaction AND PaymentMethodID = 1");

        redirect(base_url("favorite-list"));
    }
}
