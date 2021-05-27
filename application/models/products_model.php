<?php

class products_model extends CI_Model{
    
    function get_data()
    {
        $this->db->select("*");
        $this->db->from("products");
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();         
        return $query->result_array(); 

    }

    public function insert_product(){
        $data = array(
            'libelle' => $this->input->post('libelle'),
            'price' => $this->input->post('price'),
        );
        return $this->db->insert('products', $data);
    }

    function fetch_single_product($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('products');
        return $query->result_array();
    }

    function update_product($id , $data){
        
        $this->db->where('id',$id);
        $this->db->update('products',$data);

    }

    public function delete_product($id){
        $this->db->where('id', $id);
        $this->db->delete('products');

    }


}