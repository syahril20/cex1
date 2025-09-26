<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth
{
    protected $CI;

    public function __construct()
    {
        if (file_exists(APPPATH . '../vendor/autoload.php')) {
            require_once APPPATH . '../vendor/autoload.php';
        }
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
    }

    private $secret_key = 'YOUR_SECRET_KEY';

    public function generate_token($user)
    {
        $payload = [
            'iss' => 'http://localhost/cex1',
            'aud' => 'http://localhost/cex1',
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),  // 7 hari
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]
        ];

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    public function verify_token($jwt)
    {
        try {
            return JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }

    public function check_token()
    {
        
        $CI = &get_instance();  // Dapatkan instance CI
        $token = $CI->session->userdata('token');
        if (!$token)
            redirect('/login');

        // Cek token di DB
        $row = $this->CI->db->get_where('user_tokens', ['token' => $token])->row();
        if (!$row || strtotime($row->expired_at) < time()) {
            $this->CI->session->unset_userdata(['token', 'user_id']);
            $this->CI->session->set_flashdata('error', 'Session expired. Please login again.');
            redirect('/login');
        }

        return $row->user_id;
    }
}
