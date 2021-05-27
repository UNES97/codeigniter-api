<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('get_products')){
    
    function get_products(){

        $ci =& get_instance();
        $ci->db->select("id, libelle");
        $ci->db->from("products");
        $query = $ci->db->get();
        return $query->result();
    }
}


?>