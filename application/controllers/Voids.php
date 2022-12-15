<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voids extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title']              = "POS - Void Transaction | Milou";
        $statusTransactionClose     = 1;
        //$data['voidsTransaction']   = $this->M_Global->getData2WhereDateNow("Transaction", "StatusTransaction", $statusTransactionClose)->result_array();
        //$data['transactionVoid']    = $this->M_Global->getDataJoin("Transaction", "TransactionVoid", array("TransactionNumber", "TransactionNumber"))->result_array();
        $data['voids']              = $this->M_Global->query("SELECT * , Transaction.TransactionNumber as trn, Transaction.CustomerName as csn, Transaction.TotalTransaction as ttl, Transaction.TransactionID as tid, Transaction.SubTotalTransaction as sbt,
        Transaction.Discount as dsc, Transaction.TotalTransaction as ttl, Transaction.GrandTotalTransaction as gtt, Transaction.update_at FROM Transaction
        LEFT JOIN TransactionVoid on Transaction.TransactionNumber = TransactionVoid.TransactionNumber
        WHERE Transaction.StatusTransaction = '1' AND (TransactionVoid.StatusVoid = '1' OR TransactionVoid.StatusVoid IS NULL) AND Transaction.MasterOutletID = '1' order by Transaction.TransactionNumber DESC")->result_array();

        $this->render_page('pos/main/page-void/index', $data);
    }

    public function getDataAllTransaction()
    {
        $idTransaction              = $this->input->post("idTransaction");
        $data["transaction"]        = $this->M_Global->getDataWhere("Transaction", "TransactionID", $idTransaction)->result_array();
        $data["transactionDetail"]  = $this->M_Global->getDatawhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();

        echo json_encode($data);
    }

    public function insertTransactionToVoid()
    {
        $idTransaction              = $this->input->post("idTransaction");
        $data["transaction"]        = $this->M_Global->getDataWhere("Transaction", "TransactionID", $idTransaction)->result_array();
        $data["transactionDetail"]  = $this->M_Global->getDatawhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();

        $reasonVoid                 = $this->input->post('reason_void');
        $statusVoid                 = 1;
        $customerID                 = null;
        $updated                    = date('Y-m-d H:i:s', strtotime('now'));
        $cashierLoginID             = $this->session->userdata("CashierLoginID");

        foreach ($data['transaction'] as $key) {
            $transactionDateTime        = $key["TransactionDatetime"];
            $transactionNumber          = $key["TransactionNumber"];;
            $customerName               = $key["CustomerName"];
            $subTotalTransaction        = $key["SubTotalTransaction"];
            $discount                   = $key["Discount"];
            $pointRedeem                = $key["PointRedeem"];
            $totalTransaction           = $key["TotalTransaction"];
            $ppn                        = $key["PPN"];
            $grandTotalTransaction      = $key["GrandTotalTransaction"];
            $pointObtain                = $key["PointObtain"];
            $masterOutletID             = $key["MasterOutletID"];
            $payMethodTransID           = $key["PayMethodTransID"];
            $discountTransID            = $key["DiscountTransID"];
            $transactionType            = $key["TransactionType"];
            $statusTransaction          = $key["StatusTransaction"];
            $changer                    = $key["Changer"];
            $created                    = $key['created_at'];
        }

        foreach ($data["transactionDetail"] as $value) {
            $transactionID          = $value["TransactionID"];
            $menuID                 = $value["MenuID"];
            $menuName               = $value["MenuName"];
            $menuImage              = $value["MenuImage"];
            $qty                    = $value["Qty"];
            $price                  = $value["Price"];
            $priceAfterDiscount     = $value["PriceAfterDiscount"];
            $noteDetail             = $value["NoteDetail"];
            $created_at             = $value["created_at"];
            $updated_at             = $value["update_at"];
        }

        $dataTransactionVoid = array(
            'ReasonVoid'            => $reasonVoid,
            'StatusVoid'            => $statusVoid,
            'TransactionDatetime'   => $transactionDateTime,
            'TransactionNumber'     => $transactionNumber,
            'CustomerID'            => $customerID,
            'Customername'          => $customerName,
            'SubTotalTransaction'   => $subTotalTransaction,
            'Discount'              => $discount,
            'PointRedeem'           => $pointRedeem,
            'TotalTransaction'      => $totalTransaction,
            'PPN'                   => $ppn,
            'GrandTotalTransaction' => $grandTotalTransaction,
            'PointObtain'           => $pointObtain,
            'MasterOutletID'        => $masterOutletID,
            'PayMethodTransID'      => $payMethodTransID,
            'DiscountTransID'       => $discountTransID,
            'CashierLoginID'        => $cashierLoginID,
            'TransactionType'       => $transactionType,
            'StatusTransaction'     => $statusTransaction,
            'Changer'               => $changer,
            'created_at'            => $created,
            'update_at'             => $updated
        );

        $dataTransactionDetailVoid = array(
            'TransactionID'         => $transactionNumber,
            'MenuID'                => $menuID,
            'MenuName'              => $menuName,
            'MenuImage'             => $menuImage,
            'Qty'                   => $qty,
            'Price'                 => $price,
            'PriceAfterDiscount'    => $priceAfterDiscount,
            'NoteDetail'            => $noteDetail,
            'created_at'            => $created_at,
            'update_at'             => $updated_at
        );

        $data['transactionVoid']            = $this->M_Global->insert($dataTransactionVoid, "TransactionVoid");
        $data['transactionDetailVoid']      = $this->M_Global->insert($dataTransactionDetailVoid, "TransactionDetailVoid");
       /* $data['deleteTransaction']          = $this->M_Global->delete("Transaction", array("TransactionID" => $idTransaction));
        $data['deleteTransactionDetail']    = $this->M_Global->delete("TransactionDetail", array("TransactionID" => $idTransaction));*/

        echo json_encode($data);
    }
}
