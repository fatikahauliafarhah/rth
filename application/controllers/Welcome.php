<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		// Cukup panggil satu file ini saja, karena kita akan buat dia lengkap
		$this->load->view('peta_leaflet');
	}
}