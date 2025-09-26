<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('JwtAuth');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 * 	- or -
	 * 		http://example.com/index.php/welcome/index
	 * 	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$user_id = $this->jwtauth->check_token();
		$this->load->model('User_model');
		$user = $this->User_model->get_by_id($user_id);
		$row = $this->db->get_where('roles', ['id' => $user->role_id])->row();
		if (!$row) {
			$this->session->set_flashdata('message', 'Role not found');
			redirect('/login');
		}
		// if ($row->code == 'SUPER_ADMIN') {
		// 	$this->load->view('dashboard');
		// }
		// elseif ($row->code == 'ADMIN') {
		// 	$this->load->view('dashboard');
		// }
		// elseif ($row->code == 'USER') {
		// 	$this->load->view('dashboard');
		// }
		$data = [
			'role' => $row->code,
			'username' => $user->username
		];
		echo "<script>console.log('Debug: ', " . json_encode($data) . ');</script>';
		$this->load->view('dashboard', ['data' => $data]);
	}
}
