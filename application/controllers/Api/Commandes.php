<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commandes extends CI_Controller {
    public function __construct()
    {
		parent::__construct();
		$this->load->model('commandes_model');
    }
    
    public function index(){
        
		$data = $this->commandes_model->get_data();
		echo json_encode($data);
    }
    
    public function insert_commande()
	{
		$data = array(
			'client' => trim($this->input->post('client')),
			'qte'  => trim($this->input->post('qte')),
			'product_id'  => trim($this->input->post('product_id'))
		);
		$this->commandes_model->insert_commande($data);
    }
    
    function fetch_single()
    {
        if($this->input->post('id'))
        {
            $data = $this->commandes_model->fetch_single_commande($this->input->post('id'));
            foreach($data as $row)
            {
                $output['client'] = $row["client"];
                $output['qte'] = $row["qte"];
                $output['product_id'] = $row["product_id"];
            }
            echo json_encode($output);
        }
    }

    public function update_api()
	{
		$data = array(
			'client' => $this->input->post('client'),
			'qte'  => $this->input->post('qte'),
			'product_id'  => $this->input->post('product_id'),
		);
		$this->commandes_model->update_commande($this->input->post('id'),$data);
    }

    public function delete_api()
 	{
        $id = $this->input->post('id');
		    $this->commandes_model->delete_commande($id);
	}
    

}