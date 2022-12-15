<?php

class M_Global extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    function query($query)
    {
        return $this->db->query($query);
    }

    function cek_user($table, $param)
    {
        return $this->db->get_where($table, $param);
    }

    public function insert($data, $table)
    {
        $insert = $this->db->insert($table, $data);

        if (!$insert) {
            $error = $this->db->error();
        } else {
            $error = "success";
        }
        return $error;
    }

    public function update($table, $array, $where)
    {
        $this->db->where($where);
        return $this->db->update($table, $array);
    }

    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    public function getData($table)
    {
        $query = " SELECT * FROM " . $table;
        return $this->db->query($query);
    }

    public function getDataGroupBy($table, $kolom1, $kolom, $param)
    {
        $query = " SELECT * FROM " . $table . " WHERE " . $kolom1 . " = " . $param . " GROUP BY " . $kolom;
        return $this->db->query($query);
    }

    public function getDataWhere($table, $kolom, $param)
    {
        $query = "SELECT * FROM " . $table . " WHERE " . $kolom . " = " . $param;
        return $this->db->query($query);
    }

    public function getData3Where($table, $kolom1, $kolom2, $kolom3, $param1, $param2, $param3)
    {
        $query = "SELECT * FROM " . $table . " WHERE (" . $kolom1 . " = " . $param1 . " OR " . $kolom2 . " = " . $param2 . ") AND " . $kolom3 . " = " . $param3;
        return $this->db->query($query);
    }

    public function getDataWhereCount($table, $kolom1, $kolom2, $kolom3, $param1, $param2, $param3)
    {
        $query = "SELECT COUNT(TransactionDetailID) as total FROM " . $table . " WHERE (" . $kolom1 . " = " . $param1 . " OR " . $kolom2 . " = " . $param2 . ") AND " . $kolom3 . " = " . $param3;
        return $this->db->query($query);
    }

    public function getDataWhereFavorite($table, $kolom, $kolom1, $param)
    {
        $query = "SELECT * FROM " . $table . " WHERE " . $kolom . " = " . $param . " ORDER BY " . $kolom1 . " ASC ";
        return $this->db->query($query);
    }

    public function getData2Where($table, $kolom1, $kolom2, $param1, $param2)
    {
        $query = "SELECT * FROM " . $table . " WHERE " . $kolom1 . " = " . $param1 . " OR " . $kolom2 . " = " . $param2;
        return $this->db->query($query);
    }

    public function getData2WhereAnd($table, $kolom1, $kolom2, $param1, $param2)
    {
        $query = "SELECT * FROM " . $table . " WHERE " . $kolom1 . " = " . $param1 . " AND " . $kolom2 . " = " . $param2;
        return $this->db->query($query);
    }

    public function getDataWhereDateNow($table)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table . " WHERE StatusTransaction IS NULL AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataWhereDateNowNew($table, $kolom, $param)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table . " WHERE " . $kolom . " = " . $param . " AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataWhereDateNowForReceipt($table, $kolom, $param)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table . " WHERE " . $kolom . " = " . $param .  " AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataJoinWhereDateNow($table1, $table2, $kolom1 = array(), $kolom2, $kolom3, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $table1 . "." . $kolom2 . " IS NOT NULL AND " . $table1 . "." . $kolom3 . " = " . $param1 .  " AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "' ORDER BY Transaction.TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataJoinWhereDateNowConfirm($table1, $table2, $kolom1 = array(), $kolom2, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $table2 . "." . $kolom2 . " = " . $param1 .  " AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "' ORDER BY Transaction.TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataJoinWhereDateNowNew($table1, $table2, $kolom1 = array(), $kolom2, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $table1 . "." . $kolom2 . " = " . $param1 .  " AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "' ORDER BY Transaction.TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getData2WhereDateNow($table, $kolom1, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = "SELECT * FROM " . $table . " WHERE " . $kolom1 . " = " . $param1 . " AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getDataWhereJoin($table1, $table2, $kolom1 = array(), $kolom2, $param)
    {
        $query = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $kolom2 . " = " . $param;
        return $this->db->query($query);
    }

    public function getDataWhereSum($table, $kolom, $param)
    {
        $query = " SELECT SUM(Price * Qty) as total FROM " . $table . " WHERE " . $kolom . "=" . $param;
        return $this->db->query($query);
    }

    public function getDataWhereSumDateNow($table, $kolom1, $kolom2, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT COUNT(TransactionID) as total FROM " . $table . " WHERE (" . $kolom1 . " IS NULL OR " . $kolom2 . " = " . $param1 . ") AND DATE(TransactionDatetime) = '" . $dateNow . "'";
        return $this->db->query($query);
    }
    public function getDataWhereSumCustomer($table, $kolom1)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT COUNT(TransactionID) as total FROM " . $table . " WHERE " . $kolom1 . " IS NULL AND DATE(TransactionDatetime) = '" . $dateNow . "'";
        return $this->db->query($query);
    }

    public function getDataWhereOrderBy($table, $kolom1, $kolom2)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT * FROM " . $table . " WHERE " . $kolom1 . " IS NULL AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY " . $kolom2 . " DESC ";
        return $this->db->query($query);
    }

    public function getDataWhereOrderByClose($table, $kolom1, $kolom2, $param)
    {
        $query = " SELECT * FROM " . $table . " WHERE " . $kolom1 . " = " . $param . " ORDER BY " . $kolom2 . " DESC ";
        return $this->db->query($query);
    }

    public function getDataJoin($table1, $table2, $kolom1 = array())
    {
        $query = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1];
        return $this->db->query($query);
    }

    public function getDataJoin3Table($table1, $table2, $table3, $kolom1 = array(), $kolom2 = array())
    {
        $query = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " LEFT JOIN " . $table3 . " ON " . $table3 . "." . $kolom2[0] . "=" . $table1 . "." . $kolom2[1];
        return $this->db->query($query);
    }

    public function getDataJoin2TableWhere($table1, $table2, $kolom1 = array(), $kolom2, $param1)
    {
        $query = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $table1 . "." . $kolom2 . " = " . $param1;
        return $this->db->query($query);
    }

    public function getDataJoin3TableWhere($table1, $table2, $table3, $kolom1 = array(), $kolom2 = array(), $kolom3, $param1)
    {
        $query = "SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " LEFT JOIN " . $table3 . " ON " . $table3 . "." . $kolom2[0] . "=" . $table1 . "." . $kolom2[1] . " WHERE " . $table3 . "." . $kolom3 . " = " . $param1;
        return $this->db->query($query);
    }

    public function liveSearchDataMenu($table, $kolom1, $kolom2, $kolom3, $param1, $param2)
    {
        $query = " SELECT * FROM " . $table . " WHERE " . $kolom1 . "=" . $param2 . " AND " . $kolom2 . " LIKE "  . "'%{$param1}%'" . " ORDER BY " . $kolom3 . " ASC ";
        return $this->db->query($query);
    }

    public function liveSearchDataCustomer($table, $kolom1, $kolom2, $kolom3, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT * FROM " . $table . " WHERE " . $kolom2 . " LIKE "  . "'%{$param1}%'" . " AND " . $kolom3 . " IS NULL AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY " . $kolom1 . " DESC ";
        return $this->db->query($query);
    }

    public function transactionNumber()
    {
        $dateNow = date("Y-m-d");

        $this->db->select('RIGHT(Transaction.TransactionNumber,4) as transaction_number', FALSE);
        $this->db->order_by('transaction_number', 'DESC');
        $this->db->limit(1);
        $this->db->where('DATE(TransactionDatetime)', $dateNow);
        $query = $this->db->get('Transaction');

        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->transaction_number) + 1;
        } else {
            $kode = 1;
        }
        $tgl            = date('Ymd');
        $batas          = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil     = $tgl . $batas;

        return $kodetampil;
    }

    public function dateRange($start_date, $end_date, $statusTransaction)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT * FROM " . " Transaction WHERE DATE(TransactionDatetime) >= '" . $start_date . "' AND DATE(TransactionDatetime) <= '" . $end_date . "' AND StatusTransaction = '" . $statusTransaction . "' AND DATE(TransactionDatetime) = '" . $dateNow . "' ORDER BY TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function dateRangeIncome($table1, $table2, $kolom1 = array(), $start_date, $end_date, $statusTransaction, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE DATE(Transaction.TransactionDatetime) >= '" . $start_date . "' AND DATE(Transaction.TransactionDatetime) <= '" . $end_date . "' AND Transaction.StatusTransaction = '" . $statusTransaction . "' AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "' AND PayMethodtrans.PayMethodID = '" . $param1 . "' ORDER BY Transaction.TransactionDatetime DESC";
        return $this->db->query($query);
    }

    public function getVoid()
    {
        $dateNow        = date("Y-m-d");
        $statusClose    = 1;
        $query          = " SELECT *, Transaction.TransactionNumber as trn, Transaction.CustomerName as csn, Transaction.SubTotalTransaction as sbt, Transaction.TotalTransaction as ttl, Transaction.Discount as dsc, Transaction.GrandTotalTransaction as gtt, Transaction.PointRedeem as por FROM Transaction left join TransactionVoid on Transaction.TransactionNumber = TransactionVoid.TransactionNumber WHERE Transaction.StatusTransaction = '" . $statusClose . "' AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "' ORDER BY Transaction.TransactionID DESC";

        return $this->db->query($query);
    }

    public function getIncome($table1, $table2, $kolom1 = array(), $kolom2, $kolom3, $param1)
    {
        $dateNow    = date("Y-m-d");
        $query      = " SELECT * FROM " . $table1 . " LEFT JOIN " . $table2 . " ON " . $table1 . "." . $kolom1[0] . " = " . $table2 . "." . $kolom1[1] . " WHERE " . $table1 . "." . $kolom2 . " IS NOT NULL AND " . $table2 . "." . $kolom3 . " = " . $param1 . " AND DATE(Transaction.TransactionDatetime) = '" . $dateNow . "'";
        return $this->db->query($query);
    }
}
