<?php

class commandes_model extends CI_Model{
    function get_data()
    {
        $this->db->select("commandes.id as `id` , client , libelle , qte , price");
        $this->db->from("commandes");
        $this->db->join('products', 'commandes.product_id  = products.id');
		$this->db->order_by('commandes.id', 'DESC');
		$query = $this->db->get();         
        return $query->result_array(); 

    }

    public function insert_commande(){
        $data = array(
            'client' => $this->input->post('client'),
            'qte' => $this->input->post('qte'),
            'product_id' => $this->input->post('product_id'),
        );
        return $this->db->insert('commandes', $data);
    }

    function fetch_single_commande($id)
    {
        $this->db->where("id", $id);
        $query = $this->db->get('commandes');
        return $query->result_array();
    }

    function update_commande($id , $data){
        
        $this->db->where('id',$id);
        $this->db->update('commandes',$data);

    }

    public function delete_commande($id){
        
        $this->db->where('id', $id);
        $this->db->delete('commandes');

    }
}