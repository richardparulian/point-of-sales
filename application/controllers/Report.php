<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title']              = "POS - Daily Report Transaction | Milou";

        $this->render_page('pos/main/page-report/index', $data);
    }

    public function getDailyReportTransaction()
    {
        $statusTransaction = 5;
        if ($this->input->post("start_date") && $this->input->post("end_date")) {
            $start_date     = $this->input->post("start_date");
            $end_date       = $this->input->post("end_date");

            $result = $this->M_Global->dateRange($start_date, $end_date, $statusTransaction)->result_array();
        } else {
            $result = $this->M_Global->getData2WhereDateNow("Transaction", "StatusTransaction", $statusTransaction)->result_array();
        }

        echo json_encode($result);
    }

    public function getTransactionDetail()
    {
        $idTransaction  = $this->input->post("idTransaction");
        $result         = $this->M_Global->getDataWhere("TransactionDetail", "TransactionID", $idTransaction)->result_array();

        echo json_encode($result);
    }
}
