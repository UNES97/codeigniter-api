<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
    public function __construct()
    {
		parent::__construct();
		$this->load->model('products_model');
    }
    
    public function index(){
        
		$data = $this->products_model->get_data();
		echo json_encode($data);
    }
    
    public function insert_product()
	{
		$data = array(
			'libelle' => trim($this->input->post('libelle')),
			'price'  => trim($this->input->post('price'))
		);
		$this->products_model->insert_product($data);
    }
    
    function fetch_single()
    {
        if($this->input->post('id'))
        {
            $data = $this->products_model->fetch_single_product($this->input->post('id'));
            foreach($data as $row)
            {
                $output['libelle'] = $row["libelle"];
                $output['price'] = $row["price"];
            }
            echo json_encode($output);
        }
    }

    public function update_api()
	{
		$data = array(
			'libelle' => $this->input->post('libelle'),
			'price'  => $this->input->post('price')
		);
		$this->products_model->update_product($this->input->post('id'),$data);
    }

    public function delete_api()
 	{
        $id = $this->input->post('id');
		$this->products_model->delete_product($id);
	}
    

}