<?php
class Gnd_model extends CI_Model {
    
    public function __construct(){
        $this->load->database();
    }

    public function get_num_inv(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM invoice ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function get_num_quo(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM quotation ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function get_num_po(){
        $gnd_db = $this->load->database("gnd", TRUE);
        $query = "SELECT doc_num FROM po ORDER BY id DESC LIMIT 1";
        $result = $gnd_db->query($query);
        return $result->row_array();
    }

    public function set_doc_num($doc, $doc_num){
        $gnd_db = $this->load->database("gnd", TRUE);
        switch ($doc) {
            case 'Invoice':
                if($this->input->post('klien') !== false && $this->input->post('project') !== false && $this->input->post('inv_num') !== false){
                    $data = array(
                        'client'        => $this->input->post('klien'),
                        'project'       => $this->input->post('project'),
                        'inv_num'       => $this->input->post('inv_num'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('invoice', $data);
                } else{
                    return false;
                }
                break;
            case 'Quotation':
                if($this->input->post('klien') !== false && $this->input->post('project') !== false){
                    $data = array(
                        'client'        => $this->input->post('klien'),
                        'project'       => $this->input->post('project'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('quotation', $data);
                } else{
                    return false;
                }
                break;
            case 'PO':
                if($this->input->post('supplier') !== false){
                    $data = array(
                        'supplier'      => $this->input->post('supplier'),
                        'project'       => $this->input->post('project'),
                        'doc_num'       => $doc_num,
                        'user_id'       => $this->input->post('user'),
                        'creation_date' => date("Y-m-d H:i:s")
                        );
                    return $gnd_db->insert('po', $data);
                } else{
                    return false;
                }
                break;
        }
    }

    // public function get_all_inv(){
    //     $gnd_db = $this->load->database("gnd", TRUE);
    //     $gnd_db->select('id, creation_date, client, project, inv_num, doc_num');
    //     $query = $gnd_db->get('invoice');
    //     return $query->result_array();
    // }

    // public function get_inv_rpt($month){
    //     $gnd_db = $this->load->database("gnd", TRUE);
    //     $q = 'SELECT id, creation_date, client, project, inv_num, doc_num FROM invoice 
    //             WHERE MONTH (creation_date) IN( MONTH (CURDATE()), MONTH (CURDATE())-1, MONTH (CURDATE())-2 )';
    //     $query = $gnd_db->query($q);
    //     return $query->result_array();
    // }

    public function get_inv_rpt(){
        $gnd_db = $this->load->database("gnd", TRUE);
        if(!empty($month)){
            $q = 'SELECT id, creation_date, client, project, inv_num, doc_num FROM invoice 
                WHERE MONTH (creation_date) IN( MONTH(CURDATE()), MONTH (CURDATE())-1, MONTH (CURDATE())-2 )
                ORDER BY creation_date DESC';
            $query = $gnd_db->query($q);
        } else{
            $q = 'SELECT id, creation_date, client, project, inv_num, doc_num FROM invoice 
                WHERE MONTH (creation_date) IN( ?, ?, ? ) ORDER BY creation_date DESC';
            $query = $gnd_db->query($q, array(date('n'), date('n')-1, date('n')-2));
        }
        return $query->result_array();
    }

    public function get_quo_rpt(){
        $gnd_db = $this->load->database("gnd", TRUE);
        if(!empty($month)){
            $q = 'SELECT id, creation_date, client, project, doc_num FROM quotation 
                WHERE MONTH (creation_date) IN( MONTH(CURDATE()), MONTH (CURDATE())-1, MONTH (CURDATE())-2 )
                ORDER BY creation_date DESC';
            $query = $gnd_db->query($q);
        } else{
            $q = 'SELECT id, creation_date, client, project, doc_num FROM quotation 
                WHERE MONTH (creation_date) IN( ?, ?, ? ) ORDER BY creation_date DESC';
            $query = $gnd_db->query($q, array(date('n'), date('n')-1, date('n')-2));
        }
        return $query->result_array();
    }

    public function get_po_rpt(){
        $gnd_db = $this->load->database("gnd", TRUE);
        if(!empty($month)){
            $q = 'SELECT id, creation_date, supplier, project, doc_num FROM po 
                WHERE MONTH (creation_date) IN( MONTH(CURDATE()), MONTH (CURDATE())-1, MONTH (CURDATE())-2 )
                ORDER BY creation_date DESC';
            $query = $gnd_db->query($q);
        } else{
            $q = 'SELECT id, creation_date, supplier, project, doc_num FROM po 
                WHERE MONTH (creation_date) IN( ?, ?, ? ) ORDER BY creation_date DESC';
            $query = $gnd_db->query($q, array(date('n'), date('n')-1, date('n')-2));
        }
        return $query->result_array();
    }

    public function check_inv_num($klien, $project){ 
        $gnd_db = $this->load->database("gnd", TRUE);
        $param = array('client' => $klien, 'project' => $project);

        $gnd_db->select('inv_num');
        $gnd_db->from('invoice');
        $gnd_db->where($param);
        $gnd_db->order_by('inv_num', 'DESC');
        $query = $gnd_db->get();
        return $query->row_array();
    }

    public function check_inv_rpt($klien, $project, $invnum){
        $gnd_db = $this->load->database("gnd", TRUE);
        $param = array('client' => $klien, 'project' => $project, 'inv_num' => $invnum);

        $gnd_db->select('client, project, inv_num');
        $gnd_db->from('invoice');
        $gnd_db->where($param);
        $query = $gnd_db->get();
        return $query->row_array();
    }
}