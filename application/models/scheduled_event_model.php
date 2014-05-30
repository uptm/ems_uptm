<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Scheduled_Event_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    function insert_scheduled_event($_data)
    {
        $data = array(
            'Start_Date'                  => $_data->post('Start_Date'),
			'End_Date'                    => $_data->post('End_Date'),
			'Mode'                        => $_data->post('Mode'),
			'Quota'                       => $_data->post('Quota'),
			'Status'                      => $_data->post('Status'),
			'Slogan'                      => $_data->post('Slogan'),
			'Hours'                       => $_data->post('Hours'),
			'Extending_summary_date'      => $_data->post('Extending_summary_date'),
			'Extending_final_report_date' => $_data->post('Extending_final_report_date'),
			'Event_Id'                    => $_data->post('Event_Id')
		);
        
        if($this->db->insert('Scheduled_Event',$data))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    function get_all_scheduled_events(){
        $query = $this->db->get('Scheduled_Event');
        
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        else{
            return 0;
        }
    }
    
    function get_by_id($_id)
    {
        $query = $this->db->where('Id',$_id)->get('Scheduled_Event');
        
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
        }
        else{
            return 0;
        }
    }
    
    function update_scheduled_event($_data){
        
        $data = array(
            'Start_Date'                  => $_data->post('Start_Date'),
			'End_Date'                    => $_data->post('End_Date'),
			'Mode'                        => $_data->post('Mode'),
			'Quota'                       => $_data->post('Quota'),
			'Status'                      => $_data->post('Status'),
			'Slogan'                      => $_data->post('Slogan'),
			'Hours'                       => $_data->post('Hours'),
			'Extending_summary_date'      => $_data->post('Extending_summary_date'),
			'Extending_final_report_date' => $_data->post('Extending_final_report_date'),
			'Event_Id'                    => $_data->post('Event_Id')
        );
        
        if($this->db->where('Id',$_data->post('Id'))->update('Scheduled_Event',$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    /**
     * TODO: Al eliminar se debe eliminar las referencias a Sale, Register, Scheduled_Event_Account, Activity, Knowledge, Place, Planning, Certified_Design primero.
     */
    function delete_scheduled_event($id){
        
        if($this->db->where('Id',$id)->delete('Scheduled_Event')){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}