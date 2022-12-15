<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Receipt extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $statusTransaction = 5;

        $data['title']          = "POS - Receipt | Milou";
        $data['receipt']        = $this->M_Global->getDataWhereDateNowForReceipt("Transaction", "StatusTransaction", $statusTransaction)->result_array();

        $this->render_page('pos/main/page-receipt/index', $data);
    }

    public function getDataPrintBill()
    {
        $idTransaction              = $this->input->post("idTransaction");
        $data["transaction"]        = $this->M_Global->query("SELECT * FROM Transaction LEFT JOIN MasterOutlet ON Transaction.MasterOutletID = MasterOutlet.MasterOutletID WHERE Transaction.TransactionID = '$idTransaction'")->result_array();
        $data["payMethodTrans"]     = $this->M_Global->getDataWhereJoin("PayMethodTrans", "PaymentMethod", array("PaymentMethodID", "PaymentMethodID"), "TransactionID", $idTransaction)->result_array();
        $itemTransaction            = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idTransaction' AND Parent = 0")->result_array();

        $items = [];

        foreach ($itemTransaction as $key) {
            $idt    = $key['TransactionDetailID'];
            $array  = (array)$idt;

            foreach ($array as $arr) {
                $asd    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE Parent = '$arr' ")->result_array();
                $qwe    = [];

                foreach ($asd as $add) {
                    $qwe[] = array(
                        'TransactionDetailID'   => $add['TransactionDetailID'],
                        'MenuID'                => $add['MenuID'],
                        'MenuName'              => $add['MenuName'],
                        'MenuImage'             => $add['MenuImage'],
                        'Price'                 => $add['Price'],
                        'Qty'                   => $add['Qty'],
                        'NoteDetail'            => $add['NoteDetail'],
                    );
                }
            }

            $items[] = array(
                'TransactionDetailID'   => $key['TransactionDetailID'],
                'MenuID'                => $key['MenuID'],
                'MenuName'              => $key['MenuName'],
                'MenuImage'             => $key['MenuImage'],
                'Price'                 => $key['Price'],
                'Qty'                   => $key['Qty'],
                'NoteDetail'            => $key['NoteDetail'],
                'Parent'                => $qwe
            );
        }

        $data['transactionDetail'] = $items;

        echo json_encode($data);
    }
}
