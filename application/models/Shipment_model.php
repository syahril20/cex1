<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipment_model extends CI_Model
{
    protected $table = 'shipments';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        return $this->db->get('shipments')->result_array();
    }
}
