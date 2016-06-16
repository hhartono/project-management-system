<?php
class Displaytugas_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_grup()
    {
        $query = $this->db->get('group_master');
        return $query->result_array();
    }

    public function get_all_subproject()
    {
        $query = $this->db->get('subproject_master');
        return $query->result_array();
    }

    public function get_all_timeline($id)
    {
        $query = $this->db->query("Select subproject_master.name as subproject, timeline.* 
                                    FROM subproject_master, timeline, group_master
                                    Where timeline.subproject_id = subproject_master.id AND group_master.id = timeline.group_id AND timeline.group_id = '$id'");
        return $query->result_array();
    }

    public function get_timeline_id($id)
    {
        $query = $this->db->query("Select * 
                                    FROM timeline
                                    Where timeline.id = '$id'");
        return $query->result_array();
    }

    public function get_all_tugas_by_grup($grup)
    {
        $query = $this->db->query("select group_master.name as grup, subproject_master.name as subproject, timeline.status as status, timeline.next_timeline_id as nexttimeline, timeline.lama_pekerjaan as lama, timeline.id as id
                                    from group_master, subproject_master, timeline
                                    where group_master.id = timeline.group_id AND subproject_master.id = timeline.subproject_id AND group_master.name = '$grup'");
        return $query->result_array();

    }

    public function get_all_tugas_by_next($next)
    {
        $query = $this->db->query("select group_master.name as grup, subproject_master.name as subproject, timeline.status as status, timeline.next_timeline_id as nexttimeline, timeline.lama_pekerjaan as lama, timeline.id as id
                                    from group_master, subproject_master, timeline
                                    where group_master.id = timeline.group_id AND subproject_master.id = timeline.subproject_id AND timeline.id = '$next'");
        return $query->result_array();

    }

    public function get_grup_by_name($name){
        $query = $this->db->get_where('group_master', array('name' => $name));
        return $query->row_array();
    }

    public function get_subproject_by_name($name){
        $query = $this->db->get_where('subproject_master', array('name' => $name));
        return $query->row_array();
    }

    public function set_timeline($database_input_array)
    {
        if($database_input_array['grup_id'] !== false && $database_input_array['subproject_id'] !== false && $database_input_array['status'] !== false && $database_input_array['waktu'] !== false){

            $this->db->trans_start();
            $data = array(
                'group_id' => $database_input_array['grup_id'],
                'subproject_id' => $database_input_array['subproject_id'],
                'status' => $database_input_array['status'],
                'lama_pekerjaan' => $database_input_array['waktu'],
                'next_timeline_id' => $database_input_array['timeid']
            );

            $this->db->insert('timeline', $data);

            if($database_input_array['timeline'] > 0){
                $database_input_array['timeline_id'] = $this->db->insert_id();
                $data = array(
                    'next_timeline_id' => $database_input_array['timeline_id']
                );

                $this->db->where('id', $database_input_array['timeline']);
                $this->db->update('timeline', $data);

            }
            $this->db->trans_complete();

            // return false if something went wrong
            if ($this->db->trans_status() === FALSE){
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            return false;
        }
    }

}