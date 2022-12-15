<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitchen extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title']      = "Milou Farm House | Kitchen";
        $dnow               = date('Y-m-d');
        $kitch              = $this->M_Global->query("SELECT * FROM Transaction WHERE (StatusTransaction = '1' OR StatusTransaction IS NULL) AND date(TransactionDatetime) = '$dnow' ")->result_array();
        $kitchen            = [];

        foreach ($kitch as $kit) {
            $idtrans    = $kit['TransactionID'];
            $menunya    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idtrans' AND StatusForKitchen = '1' AND Parent = 0 ")->result_array();
            $menu       = [];

            foreach ($menunya as $key) {
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

                $menu[] = array(
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

            $kitchen[] = array(
                'TransactionID'         => $kit['TransactionID'],
                'CustomerName'          => $kit['CustomerName'],
                'TransactionNumber'     => $kit['TransactionNumber'],
                'TransactionDatetime'   => $kit['TransactionDatetime'],
                'TransactionType'       => $kit['TransactionType'],
                'Menu'                  => $menu
            );
        }
        $data['kitchen'] = $kitchen;

        $this->render_page_kitchen('kitchen/main/page-main/index', $data);
    }

    public function loadAjax()
    {
        $data['title']  = "Milou Farm House | Kitchen";
        $dnow           = date('Y-m-d');
        $kitch          = $this->M_Global->query("SELECT * FROM Transaction WHERE (StatusTransaction = '1' OR StatusTransaction IS NULL) AND date(TransactionDatetime) = '$dnow' order by TransactionDatetime asc ")->result_array();
        $kitchen        = [];

        foreach ($kitch as $kit) {
            $idtrans    = $kit['TransactionID'];
            $menunya    = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idtrans' AND StatusForKitchen = '1' AND Parent = 0 ")->result_array();
            $menu       = [];

            foreach ($menunya as $key) {
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

                $menu[] = array(
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

            $kitchen[] = array(
                'TransactionID'         => $kit['TransactionID'],
                'CustomerName'          => $kit['CustomerName'],
                'TransactionNumber'     => $kit['TransactionNumber'],
                'TransactionDatetime'   => $kit['TransactionDatetime'],
                'TransactionType'       => $kit['TransactionType'],
                'Menu'                  => $menu
            );
        }

        $data['kitchen'] = $kitchen;

        $this->load->view('kitchen/main/header');
        $this->load->view('kitchen/main/page-main/loadAjax', $data);
    }

    public function listPreparing()
    {
        $data['title']      = "Milou Farm House | Kitchen";
        $dnow               = date('Y-m-d');

        $this->render_page_kitchen('kitchen/main/page-main/indexPreparing', $data);
    }


    public function listReady()
    {
        $data['title']      = "Milou Farm House | Kitchen";
        $dnow               = date('Y-m-d');

        $this->render_page_kitchen('kitchen/main/page-main/indexReady', $data);
    }


    public function loadReady()
    {
        $data['title']      = "Milou Farm House | Kitchen";
        $dnow               = date('Y-m-d');
        $data['kitchen']    = $this->M_Global->query("SELECT * FROM Transaction WHERE (StatusTransaction = '1' OR StatusTransaction IS NULL) AND date(TransactionDatetime) = '$dnow' order by TransactionDatetime asc ")->result_array();
        $mp                 = [];

        foreach ($data['kitchen'] as $prep) {
            $idtrn              = $prep['TransactionID'];
            $detail             = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idtrn' and StatusForKitchen = '2' and StatusTransactionDetail = '1' AND Parent = 0 ")->result_array();
            $menu               = [];

            // foreach ($detail as $dt) {
            //     $menu[] = array(
            //         'TransactionDetailID'       => $dt['TransactionDetailID'],
            //         'StatusTransactionDetail'   => $dt['StatusTransactionDetail'],
            //         'MenuName'                  => $dt['MenuName'],
            //         'NoteDetail'                => $dt['NoteDetail'],
            //         'Qty'                       => $dt['Qty']
            //     );
            // }

            foreach ($detail as $key) {
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

                $menu[] = array(
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

            if ($detail) {

                $mp[] = array(
                    'TransactionID'         => $prep['TransactionID'],
                    'CustomerName'          => $prep['CustomerName'],
                    'TransactionNumber'     => $prep['TransactionNumber'],
                    'TransactionDatetime'   => $prep['TransactionDatetime'],
                    'TransactionType'       => $prep['TransactionType'],
                    'Menu'                  => $menu
                );
            }
        }
        $data['menuPreparing'] = $mp;

        $this->load->view('kitchen/main/header');
        $this->load->view('kitchen/main/page-main/loadReady', $data);
    }

    public function loadPreparing()
    {
        $data['title']      = "Milou Farm House | Kitchen";
        $dnow               = date('Y-m-d');
        $data['kitchen']    = $this->M_Global->query("SELECT * FROM Transaction WHERE (StatusTransaction = '1' OR StatusTransaction IS NULL) AND date(TransactionDatetime) = '$dnow' order by TransactionDatetime asc")->result_array();
        $mp                 = [];

        foreach ($data['kitchen'] as $prep) {
            $idtrn              = $prep['TransactionID'];
            $detail             = $this->M_Global->query("SELECT * FROM TransactionDetail WHERE TransactionID = '$idtrn' AND StatusForKitchen = '2' AND StatusTransactionDetail IS NULL ")->result_array();
            $menu               = [];

            foreach ($detail as $dt) {
                $menu[] = array(
                    'TransactionDetailID'       => $dt['TransactionDetailID'],
                    'StatusTransactionDetail'   => $dt['StatusTransactionDetail'],
                    'MenuName'                  => $dt['MenuName'],
                    'NoteDetail'                => $dt['NoteDetail'],
                    'Qty'                       => $dt['Qty']
                );
            }
            if ($detail) {

                $mp[] = array(
                    'TransactionID'         => $prep['TransactionID'],
                    'CustomerName'          => $prep['CustomerName'],
                    'TransactionNumber'     => $prep['TransactionNumber'],
                    'TransactionDatetime'   => $prep['TransactionDatetime'],
                    'TransactionType'       => $prep['TransactionType'],
                    'Menu'                  => $menu
                );
            }
        }
        $data['menuPreparing'] = $mp;

        $this->load->view('kitchen/main/header');
        $this->load->view('kitchen/main/page-main/loadPreparing', $data);
    }

    public function preparing()
    {
        $idTransaction      = $this->input->post("transactionID");
        $transaction        = $this->M_Global->getDataWhere("Transaction", "TransactionID", $idTransaction)->result_array();

        if ($transaction[0]['TransactionType'] == 2) {
            $statusTransaction  = 1;
        } else {
            $statusTransaction  = null;
        }

        $dataT = array(
            'StatusTransaction' => $statusTransaction
        );
        $result = $this->M_Global->update("Transaction", $dataT, array("TransactionID" => $idTransaction));

        $dataTD = array(
            'StatusForKitchen'  => 2
        );
        $result = $this->M_Global->query("UPDATE TransactionDetail SET StatusForKitchen = '2' WHERE TransactionID = '$idTransaction' AND StatusForKitchen = '1' ");

        echo json_encode($result);
    }

    public function updateStatusItem()
    {
        $statusTransactionDetail    = $this->input->post("status_td");
        $idTransactionDetail        = $this->input->post("transactionDetailID");

        $data = array(
            'StatusTransactionDetail' => $statusTransactionDetail
        );

        $result = $this->M_Global->update("TransactionDetail", $data, array("TransactionDetailID" => $idTransactionDetail));

        echo json_encode($result);
    }

    public function ready()
    {
        $statusTransaction  = 5;
        $idTransaction      = $this->input->post("transactionID");

        $data = array(
            'StatusTransaction' => $statusTransaction
        );

        $result = $this->M_Global->update("Transaction", $data, array("TransactionID" => $idTransaction));

        echo json_encode($result);
    }

    public function countNewOrder()
    {
        $statusTransaction          = 1;
        $countOrderNewOrder         = $this->M_Global->getDataWhereSumDateNow("Transaction", "StatusTransaction", "StatusTransaction", $statusTransaction)->row_array();

        echo json_encode($countOrderNewOrder);
    }

    public function countPreparing()
    {
        $statusTransaction      = 1;
        $countOrderPreparing    = $this->M_Global->getDataWhereSumDateNow("Transaction", "StatusTransaction", "StatusTransaction", $statusTransaction)->row_array();

        echo json_encode($countOrderPreparing);
    }

    public function countReady()
    {
        $statusTransaction      = 1;
        $countOrderPreparing    = $this->M_Global->getDataWhereSumDateNow("Transaction", "StatusTransaction", "StatusTransaction", $statusTransaction)->row_array();

        echo json_encode($countOrderPreparing);
    }
}
