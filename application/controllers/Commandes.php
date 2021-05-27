<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commandes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['products'] = get_products();
		$this->load->view('commandes_index' , $data);
	}

	public function get_items()
	{
	   $getbin  = 'http://localhost/ci_api/index.php/api/commandes';
		$get  = curl_init();
		curl_setopt($get, CURLOPT_URL, $getbin);
		curl_setopt($get, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($get, CURLOPT_FOLLOWLOCATION, true);
		$exec  = curl_exec($get);
		curl_close($get);
		$query = json_decode($exec);
		
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));

	   $data = [];
	   foreach($query as $r) {
			$data[] = array(
				 $r->id,
				 $r->client,
				 $r->libelle,
				 $r->price ,
				 $r->qte ,
				 $r->qte * $r->price ,
				 $r->href='<a href="javascript:void(0)" data-id="'.$r->id.'" class="btn btn-sm btn-primary edit_cmd">Edit</a>
				 <a href="javascript:void(0)" data-id="'.$r->id.'" class="btn btn-sm btn-danger delete_cmd">Delete</a>'
			);
	   }
	   $result = array(
				"draw" => $draw,
				"recordsTotal" => count($query),
				"recordsFiltered" => count($query),
				"data" => $data
			 );
	   echo json_encode($result);
	   exit();
	}

	public function insert_to_api(){
		$api_url = "http://localhost/ci_api/index.php/api/commandes/insert_commande";
		$form_data = array(
			'client' => trim($this->input->post('client')),
			'qte'  => trim($this->input->post('qte')),
			'product_id'  => trim($this->input->post('product_id'))
		);
		$product = curl_init($api_url);
		curl_setopt($product, CURLOPT_POST, true);
		curl_setopt($product, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($product, CURLOPT_RETURNTRANSFER, true);
		curl_exec($product);
		curl_close($product);
	}

	public function fetch_commande_api(){
		$api_url = "http://localhost/ci_api/index.php/api/commandes/fetch_single";
		$form_data = array(
			'id'  => $this->input->post('id')
		);
		$product = curl_init($api_url);
		curl_setopt($product, CURLOPT_POST, true);
		curl_setopt($product, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($product, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($product);
		curl_close($product);
		echo $response;
	}

	public function update_to_api(){
		$form_data = array(
			'client' => $this->input->post('client'),
			'qte'  => $this->input->post('qte'),
			'product_id'  => $this->input->post('product_id'),
			'id'    => $this->input->post('id')
		);
		$api_url = "http://localhost/ci_api/index.php/api/commandes/update_api";
		$product = curl_init($api_url);
		curl_setopt($product, CURLOPT_POST, true);
		curl_setopt($product, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($product, CURLOPT_RETURNTRANSFER, true);
		curl_exec($product);
		curl_close($product);
	}

	public function delete_to_api(){
		$api_url = "http://localhost/ci_api/index.php/api/commandes/delete_api";
		$form_data = array(
			'id'  => $this->input->post('id')
		);
		$product = curl_init($api_url);
		curl_setopt($product, CURLOPT_POST, true);
		curl_setopt($product, CURLOPT_POSTFIELDS, $form_data);
		curl_setopt($product, CURLOPT_RETURNTRANSFER, true);
		curl_exec($product);
		curl_close($product);
	}

}
