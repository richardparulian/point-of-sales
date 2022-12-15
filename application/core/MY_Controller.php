<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        ini_set('display_errors', 'off');
    }

    function render_page_auth($content, $data = NULL)
    {
        $data['header']         = $this->load->view('pos/auth/header', $data, TRUE);
        $data['content']        = $this->load->view($content, $data, TRUE);
        $data['footer']         = $this->load->view('pos/auth/footer', $data, TRUE);

        $this->load->view('pos/auth/index', $data);
    }

    function render_page($content, $data = NULL)
    {
        $data['header']         = $this->load->view('pos/main/header', $data, TRUE);
        $data['leftSideBar']    = $this->load->view('pos/main/left-sidebar', $data, TRUE);
        $data['content']        = $this->load->view($content, $data, TRUE);
        $data['modal']          = $this->load->view('pos/main/modal', $data, TRUE);
        $data['footer']         = $this->load->view('pos/main/footer', $data, TRUE);

        $this->load->view('pos/main/index', $data);
    }

    function render_page_kitchen($content, $data = NULL)
    {
        $data['header']         = $this->load->view('kitchen/main/header', $data, TRUE);
        $data['navbar']         = $this->load->view('kitchen/main/navbar', $data, TRUE);
        $data['content']        = $this->load->view($content, $data, TRUE);
        $data['footer']         = $this->load->view('kitchen/main/footer', $data, TRUE);

        $this->load->view('kitchen/main/index', $data);
    }
}
