<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('Username')) {
            redirect('favorite-list');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title_login'] = "Milou Farm House | Sign In";

            $this->render_page_auth('pos/auth/page-login/index', $data);
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');


        $where      = array(
            'username' => $username
        );
        $user           = $this->M_Global->cek_user('CashierLogin', $where)->row_array();

        if ($user) {
            if ($password == $user['Password']) {
                $data = [
                    'CashierLoginID'    => $user['CashierLoginID'],
                    'Username'          => $user['Username'],
                    'Type'              => $user['Type'],
                    'Status'            => 'success'
                ];
                $this->session->set_userdata($data);

                if ($user['Type'] == 1) {
                    redirect('favorite-list');
                } elseif ($user['Type'] == 2) {
                    redirect('favorite-list');
                } else {
                    redirect('favorite-list');
                }
            } else {
                $this->session->set_flashdata('message', 'Wrong password! Please check your password again.');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', 'Username is not Registered!');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('sign-in');
    }
}
