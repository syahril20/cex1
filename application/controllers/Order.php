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

    public function order_form()
    {
        $this->jwtauth->check_token();
        $user = $this->session->userdata('user');
        if ($user->code != 'AGENT') {
            redirect('/');
        }
        $this->load->view('agent/agent_order_form');
    }

    public function upload_shipment_form($orderId)
    {
        $order = $this->db->get_where('orders', ['id' => $orderId])->row();
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('/order');
        }

        $data['order'] = $order;
        $this->load->view('agent/agent_upload_form', $data);
    }

    public function detail($orderId)
    {
        $this->jwtauth->check_token();
        $order = $this->db->get_where('orders', ['id' => $orderId])->row();
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('/order');
            return;
        }

        // $orderItems = $this->db->get_where('order_items', ['order_id' => $orderId])->result();

        // $data['order'] = $order;
        // $data['orderItems'] = $orderItems;
        $this->load->view('agent/agent_order_detail');
    }
}
