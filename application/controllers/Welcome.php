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
	 * 
	 */
	public function index()
	{
		$this->jwtauth->check_token();
		$userdata = $this->session->userdata('token');
		$user = $this->session->userdata('user');
		echo "<script>console.log('ad: ', " . json_encode($userdata) . ');</script>';

		echo "<script>console.log('Debug: ', " . json_encode($user->code) . ');</script>';

		if ($user->code == 'SUPER_ADMIN') {
			$this->load->view('superadmin/superadmin_dashboard');
		}
		if ($user->code == 'ADMIN') {
			$this->load->view('admin/admin_dashboard');
		}
		if ($user->code == 'AGENT') {
			$this->load->view('agent/agent_dashboard');
		}
		// elseif ($row->code == 'ADMIN') {
		// 	$this->load->view('dashboard');
		// }
		// elseif ($row->code == 'USER') {
		// 	$this->load->view('dashboard');
		// }
		// $data = [
		// 	'role' => $row->code,
		// 	'username' => $user->username
		// ];
		// echo "<script>console.log('Debug: ', " . json_encode($data) . ');</script>';
		// $this->load->view('dashboard', ['data' => $data]);
	}
}
