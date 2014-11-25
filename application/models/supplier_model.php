<?php
class Supplier_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_supplier_by_id($id){
        $query = $this->db->get_where('supplier_master', array('id' => $id));
        return $query->row_array();
    }

    public function get_supplier_by_name($name){
        $query = $this->db->get_where('supplier_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_all_suppliers()
    {
        $query = $this->db->get('supplier_master');
        return $query->result_array();
    }

    public function update_supplier()
    {
        if($this->input->post('id') !== false && $this->input->post('name') !== false
            && $this->input->post('address') !== false && $this->input->post('city') !== false
            && $this->input->post('postal_code') !== false && $this->input->post('province') !== false
            && $this->input->post('phone_number_1') !== false && $this->input->post('phone_number_2') !== false
            && $this->input->post('phone_number_3') !== false && $this->input->post('fax') !== false
            && $this->input->post('email') !== false && $this->input->post('website') !== false){
            $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'postal_code' => $this->input->post('postal_code'),
                'province' => $this->input->post('province'),
                'phone_number_1' => $this->input->post('phone_number_1'),
                'phone_number_2' => $this->input->post('phone_number_2'),
                'phone_number_3' => $this->input->post('phone_number_3'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website')
            );

            $this->db->where('id', $this->input->post('id'));
            return $this->db->update('supplier_master', $data);
        }else{
            return false;
        }
    }

    public function set_supplier()
    {
        if($this->input->post('name') !== false && $this->input->post('address') !== false
            && $this->input->post('city') !== false && $this->input->post('postal_code') !== false
            && $this->input->post('province') !== false && $this->input->post('phone_number_1') !== false
            && $this->input->post('phone_number_2') !== false && $this->input->post('phone_number_3') !== false
            && $this->input->post('fax') !== false && $this->input->post('email') !== false
            && $this->input->post('website') !== false){
            date_default_timezone_set('Asia/Jakarta');

            $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'postal_code' => $this->input->post('postal_code'),
                'province' => $this->input->post('province'),
                'phone_number_1' => $this->input->post('phone_number_1'),
                'phone_number_2' => $this->input->post('phone_number_2'),
                'phone_number_3' => $this->input->post('phone_number_3'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'website' => $this->input->post('website'),
                'creation_date' => date("Y-m-d H:i:s"),
            );

            return $this->db->insert('supplier_master', $data);
        }else{
            return false;
        }
    }

    public function delete_supplier($supplier_id){
        $response = $this->db->delete('supplier_master', array('id' => $supplier_id));
        $affected_row = $this->db->affected_rows();

        $delete_status = false;
        if($response === true && $affected_row > 0){
            $delete_status = true;
        }

        return $delete_status;
    }
}