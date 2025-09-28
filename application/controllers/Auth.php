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
class Auth extends CI_Controller
{
    public function register()
    {
        $roles = $this->db->get('roles')->result();
        $token = $this->session->userdata('token');
        if ($token) {
            redirect('/');
        }
        $this->load->view('auth/register', ['roles' => $roles]);
    }

    public function password()
    {
        $this->load->view('auth/password');
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->database();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
        $this->load->library('JwtAuth');
        $this->load->helper('security');
    }

    // Form register
    // public function register() {
    //     $roles = $this->db->get('roles')->result();
    //     $this->load->view('auth/register', ['roles' => $roles]);
    // }

    // Proses register
    public function do_register()
    {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $role_id = $this->input->post('role_id');

        // Validasi unik
        if (!$this->User_model->is_unique_username($username)) {
            $this->session->set_flashdata('error', 'Username sudah dipakai');
            redirect('auth/register');
        }

        if (!$this->User_model->is_unique_email($email)) {
            $this->session->set_flashdata('error', 'Email sudah dipakai');
            redirect('auth/register');
        }

        // Insert data
        $data = [
            'id' => $this->generate_uuid(),
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role_id' => $role_id,
            'created_by' => 'system'
        ];

        if ($this->User_model->insert_user($data)) {
            $this->session->set_flashdata('success', 'Register berhasil, silakan login.');
            redirect('/login');
        } else {
            $this->session->set_flashdata('error', 'Register gagal.');
            redirect('auth/register');
        }
    }

    private function generate_uuid()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFF) | 0x4000,
            mt_rand(0, 0x3FFF) | 0x8000,
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF),
            mt_rand(0, 0xFFFF)
        );
    }

    public function login_form()
    {
        $token = $this->session->userdata('token');
        if ($token) {
            redirect('/');
        }
        $this->load->view('auth/login');
    }

    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('User_model');
        $user = $this->User_model->get_by_email($email);

        if (!$user || !password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('/login');
        }

        // Buat JWT
        $this->load->library('JwtAuth');
        $token = $this->jwtauth->generate_token($user);

        // Delete old tokens
        $this->db->delete('user_tokens', ['user_id' => $user->id]);

        // Simpan ke DB
        $expired_at = date('Y-m-d H:i:s', strtotime('+7 days'));
        $this->db->insert('user_tokens', [
            'id' => $this->generate_uuid(),
            'user_id' => $user->id,
            'token' => $token,
            'expired_at' => $expired_at
        ]);

        // Simpan token di session
        $this->session->set_userdata('token', $token);
        $this->session->set_userdata('user', $user);
        // $this->session->set_userdata('role', $role);

        // $this->load->view('dashboard');
        redirect('/');  // atau halaman utama
    }

    // Logout user
    public function logout()
    {
        $token = $this->session->userdata('token');

        // Hapus token dari database jika pakai JWT token
        if ($token) {
            $this->db->delete('user_tokens', ['token' => $token]);
        }

        // Hapus session
        $this->session->unset_userdata(['token', 'user_id']);

        // Optional: flash message
        $this->session->set_flashdata('success', 'You have successfully logged out.');

        // Redirect ke halaman login
        redirect('/login');
    }
}
