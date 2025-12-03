<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		// Ini perintah untuk memanggil file desain di folder Views
		$this->load->view('home_view'); 
	}
}