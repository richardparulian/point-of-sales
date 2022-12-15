<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Income extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title']  = "POS - Income Report Transaction | Milou";

        $this->render_page('pos/main/page-income/index', $data);
    }

    public function getReportIncomeByDate()
    {
        $paymentMethod  = $this->M_Global->getData("PaymentMethod")->result_array();
        $incomeResult = [];

        if ($this->input->post("start_date") && $this->input->post("end_date")) {
            $start_date     = $this->input->post("start_date");
            $end_date       = $this->input->post("end_date");

            foreach ($paymentMethod as $value) {
                $paymentMethodID    = $value['PaymentMethodID'];
                $paymentMethodName  = $value['PaymentMethodName'];
                $statusClose        = 5;
                $income             = $this->M_Global->dateRangeIncome("Transaction", "PayMethodTrans", array("TransactionID", "TransactionID"), $start_date, $end_date, $statusClose, $paymentMethodID)->result_array();
                $totalIncome        = array_sum(array_column($income, 'Nominal'));

                $incomeResult[] = array(
                    'PaymentMethodID'   => $paymentMethodID,
                    'PaymentMethodName' => $paymentMethodName,
                    'TotalTransaction'  => $totalIncome,
                    'TransData'         => $income,
                );
            }
        } else {
            foreach ($paymentMethod as $value) {
                $paymentMethodID    = $value['PaymentMethodID'];
                $paymentMethodName  = $value['PaymentMethodName'];
                //$statusClose        = 5;
                $income             = $this->M_Global->getIncome("Transaction", "PayMethodTrans", array("TransactionID", "TransactionID"), "StatusTransaction", "PaymentMethodID", $paymentMethodID)->result_array();
                $totalIncome        = array_sum(array_column($income, 'Nominal'));

                $incomeResult[] = array(
                    'PaymentMethodID'   => $paymentMethodID,
                    'PaymentMethodName' => $paymentMethodName,
                    'TotalTransaction'  => $totalIncome,
                    'TransData'         => $income,
                );
            }
        }
        $result = $incomeResult;

        echo json_encode($result);
    }

    public function asd()
    {
        $data['title'] = "Joanne Studio | Report Income";
        $from = $this->input->post('from');
        $until = $this->input->post('until');
        // $store = $this->session->userdata('StoreID');
        $storeid = $this->session->userdata('OutletID');
        $menu = $this->input->post('exportExcel');
        if ($menu == "export") {
            $data['excel'] = 1;

            $filename = "IncomeTransaction-" . date('Y-m-d-His') . ".xls";
            header('Content-disposition: attachment; filename="' . $filename . '"');
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
        }

        $dnow = date('Y-m-d');

        $queryResult = [];
        $queryMethod = $this->M_Global->globalquery("SELECT PaymentMethodID,PaymentMethodName 
            FROM PaymentMethod
            union select 9999,'Redeem'")->result_array();

        if (isset($from)) {
            foreach ($queryMethod as $val) {
                $PaymentMethodID = $val['PaymentMethodID'];
                $PaymentMethodName = $val['PaymentMethodName'];

                $queryTrans = $this->M_Global->globalquery("SELECT * 
                FROM Transaction 
                    LEFT JOIN PaymentMethodCustomer ON Transaction.TransactionID = PaymentMethodCustomer.TransactionID
                WHERE 
                    date(TransactionDatetime) >= '$from' AND 
                    date(TransactionDatetime) <= '$until' AND 
                    StatusTransaction = '1' AND 
                    PaymentMethodCustomer.PaymentMethodID = '$PaymentMethodID' AND
                    TransactionTypeID = 1 AND
                    StoreID = '$storeid'")->result_array();


                if ($PaymentMethodID == 9999) {
                    $queryTrans = $this->M_Global->globalquery("
                    SELECT 
                        * 
                    FROM 
                        Transaction 
                    WHERE 
                        date(TransactionDatetime) >= '$from' AND 
                        date(TransactionDatetime) <= '$until' AND 
                        StatusTransaction = '1' AND
                        PointSpent != 0 AND
                        TransactionTypeID = 1 AND
                        StoreID = '$storeid'
                        ")->result_array();

                    $TotTrans = array_sum(array_column($queryTrans, 'PointSpent'));
                } else {
                    $TotTrans = array_sum(array_column($queryTrans, 'NominalPayment'));
                }

                $queryResult[] = array(
                    'PaymentMethodID' => $PaymentMethodID,
                    'PaymentMethodName' => $PaymentMethodName,
                    'TotalTransaction' => $TotTrans,
                    'TransData' => $queryTrans,
                );
            }
        } else {
            foreach ($queryMethod as $val) {
                $PaymentMethodID = $val['PaymentMethodID'];
                $PaymentMethodName = $val['PaymentMethodName'];

                $queryTrans = $this->M_Global->globalquery("SELECT * 
                FROM Transaction 
                    LEFT JOIN PaymentMethodCustomer ON Transaction.TransactionID = PaymentMethodCustomer.TransactionID
                WHERE 
                    date(TransactionDatetime) = '$dnow' AND 
                    StatusTransaction = '1' AND 
                    PaymentMethodCustomer.PaymentMethodID = '$PaymentMethodID' AND
                    TransactionTypeID = 1 AND
                    StoreID = '$storeid'")->result_array();


                if ($PaymentMethodID == 9999) {
                    $queryTrans = $this->M_Global->globalquery("
                    SELECT 
                        * 
                    FROM 
                        Transaction 
                    WHERE 
                        date(TransactionDatetime) = '$dnow' AND 
                        StatusTransaction = '1' AND
                        PointSpent != 0 AND
                        TransactionTypeID = 1 AND
                        StoreID = '$storeid'
                        ")->result_array();

                    $TotTrans = array_sum(array_column($queryTrans, 'PointSpent'));
                } else {
                    $TotTrans = array_sum(array_column($queryTrans, 'NominalPayment'));
                }

                $queryResult[] = array(
                    'PaymentMethodID' => $PaymentMethodID,
                    'PaymentMethodName' => $PaymentMethodName,
                    'TotalTransaction' => $TotTrans,
                    'TransData' => $queryTrans,
                );
            }
        }

        $data['store'] = $this->M_Global->globalquery("SELECT * from StoreLocationMaster
            where StoreID = '$storeid'")->result_array();

        $data['report'] = $queryResult;

        $this->render_page('main/home/page_income', $data);
    }
}
