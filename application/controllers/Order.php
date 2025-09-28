<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * (No code provided in the selection.)
 * @property CI_DB $db
 * @property CI_Session $session
 * @property User_model $User_model
 * @property JwtAuth $jwtauth
 * @property CI_Input $input
 * Please provide the code selection you want documented.
 */
class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('');
        $this->load->library('JwtAuth');
    }

    public function index()
    {
        $this->jwtauth->check_token();
        $user = $this->session->userdata('user');
        $this->load->view('agent/agent_order');
    }

    public function order_form() {
        $this->jwtauth->check_token();
        $user = $this->session->userdata('user');
        if ($user->code != 'AGENT') {
            redirect('/');
        }
        $this->load->view('agent/agent_order_form');
    }
}
